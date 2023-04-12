<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\Message;
use Carbon\Carbon;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Message\Attachment;
use Exception;
use App\Models\Settings;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;



class TrashMail extends Model
{
    use HasFactory;

    protected $fillable = ['delete_in', 'email'];

    public static function connection()
    {
        $flag = '/imap/' . Settings::selectSettings('imap_encryption') ;

        if(Settings::selectSettings('imap_certificate') == 0){
            $flag .= '/novalidate-cert';
        }else{
            $flag .= '/validate-cert';
        }

        $server = new Server(Settings::selectSettings('imap_host'),Settings::selectSettings('imap_port'),$flag);
        $connection = $server->authenticate(Settings::selectSettings('imap_user'), Settings::selectSettings('imap_pass'));
        return $connection;
    }


    public static function allMessages($email)
    {
        try {
            $connection = TrashMail::connection();
            $mailbox = $connection->getMailbox('INBOX');
            $search = new SearchExpression();
            $search->addCondition(new To($email));
            $messages = $mailbox->getMessages($search, \SORTDATE, true);

            $response = [
                'mailbox' => $email,
                'messages' => []
            ];
            foreach ($messages as $message) {

                $id = Hashids::encode($message->getNumber());

                if (!$message->isSeen()) {
                    Settings::updateSettings(
                        'total_messages_received',
                        Settings::selectSettings('total_messages_received') + 1
                    );
                    $message->markAsSeen();
                }


                $data = Cache::remember($id, Settings::selectSettings("email_lifetime") * Settings::selectSettings("email_lifetime_type") * 60, function () use ($message, $id) {

                    $sender = $message->getFrom();
                    $date = $message->getDate();
                    $date = new Carbon($date);
                    $data['subject'] = $message->getSubject();
                    $data['is_seen'] = $message->isSeen();
                    $data['from'] = $sender->getName();
                    $data['from_email'] = $sender->getAddress();
                    $data['receivedAt'] = $date->format('Y-m-d H:i:s');
                    $data['id'] = $id;
                    $data['attachments'] = [];

                    $html = $message->getBodyHtml();
                    if ($html) {
                        $data['content'] = str_replace('<a', '<a target="blank"', $html);
                    } else {
                        $text = $message->getBodyText();
                        $data['content'] = str_replace('<a', '<a target="blank"', str_replace(array("\r\n", "\n"), '<br/>', $text));
                    }

                    if ($message->hasAttachments()) {
                        $attachments = $message->getAttachments();
                        $directory = './temp/attachments/' . $message->getNumber() . '/';
                        $download = './download/' . $id . '/';
                        is_dir($directory) ?: mkdir($directory, 0777, true);
                        foreach ($attachments as $attachment) {
                            $filenameArray = explode('.', $attachment->getFilename());
                            $extension = strtolower(end($filenameArray));
                            $allowed = explode(',', Settings::selectSettings('allowed_files'));
                            if (in_array($extension, $allowed)) {
                                if (!file_exists($directory . $attachment->getFilename())) {
                                    file_put_contents(
                                        $directory . $attachment->getFilename(),
                                        $attachment->getDecodedContent()
                                    );
                                }
                                if ($attachment->getFilename() !== 'undefined') {
                                    $url = Settings::selectSettings('site_url') . str_replace('./', '/', $download . $attachment->getFilename());
                                    array_push($data['attachments'], [
                                        'file' => $attachment->getFilename(),
                                        'url' => $url
                                    ]);
                                }
                            }
                        }
                    }
                    return $data;
                });


                array_push($response["messages"], $data);
            }
            return $response;
        } catch (Exception $e) {
            $response = [
                'mailbox' => "Erorr :/ , Please Reload Page Agin ",
                'messages' => []
            ];
        }
    }



    public static function DeleteEmail($email)
    {
        try {
            $connection = TrashMail::connection();
            $mailbox = $connection->getMailbox('INBOX');
            $search = new SearchExpression();
            $search->addCondition(new To($email));
            $messages = $mailbox->getMessages($search, \SORTDATE, true);

            foreach ($messages as $message) {

                $id = $message->getNumber();

                $hashid = Hashids::encode($message->getNumber());

                Cache::forget($hashid);

                $mailbox->getMessage($id)->delete();

                if (file_exists('../temp/attachments/' . $id)) {

                    File::deleteDirectory('../temp/attachments/' . $id);
                }
            }

            $tashmail = TrashMail::where('email', $email)->first();

            if ($tashmail) {
                $tashmail->delete();
            }

            $connection->expunge();

            return "Email Deleted \n";

        } catch (Exception $e) {
            return $e->getMessage() . "\n";
        }
    }


    public static function DeleteMessage($id)
    {
        try {
            $connection = TrashMail::connection();
            $mailbox = $connection->getMailbox('INBOX');
            $mailbox->getMessage($id)->delete();
            $connection->expunge();
        } catch (Exception $e) {
            \abort(404);
        }
    }


    public static function messages($id)
    {
        try {

            $id_hash = Hashids::decode($id);

            $connection = TrashMail::connection();
            $mailbox = $connection->getMailbox('INBOX');
            $message = $mailbox->getMessage($id_hash[0]);

            $response = [];

            $sender = $message->getFrom();
            $date = $message->getDate();
            $date = new Carbon($date);
            $data['subject'] = $message->getSubject();
            $data['is_seen'] = $message->isSeen();
            $data['from'] = $sender->getName();
            $data['from_email'] = $sender->getAddress();
            $data['receivedAt'] = $date->format('Y-m-d H:i:s');
            $data['id'] = $message->getNumber();
            $data['attachments'] = [];

            $html = $message->getBodyHtml();
            if ($html) {
                $data['content'] = str_replace('<a', '<a target="blank"', $html);
            } else {
                $text = $message->getBodyText();
                $data['content'] = str_replace('<a', '<a target="blank"', str_replace(array("\r\n", "\n"), '<br/>', $text));
            }

            if ($message->hasAttachments()) {
                $attachments = $message->getAttachments();
                $directory = './temp/attachments/' . $data['id'] . '/';
                $download = './download/' . $id . '/';
                is_dir($directory) ?: mkdir($directory, 0777, true);
                foreach ($attachments as $attachment) {
                    $filenameArray = explode('.', $attachment->getFilename());
                    $extension = strtolower(end($filenameArray));
                    $allowed = explode(',', Settings::selectSettings('allowed_files'));
                    if (in_array($extension, $allowed)) {
                        if (!file_exists($directory . $attachment->getFilename())) {
                            file_put_contents(
                                $directory . $attachment->getFilename(),
                                $attachment->getDecodedContent()
                            );
                        }
                        if ($attachment->getFilename() !== 'undefined') {
                            $url = Settings::selectSettings('site_url') . str_replace('./', '/', $download . $attachment->getFilename());
                            array_push($data['attachments'], [
                                'file' => $attachment->getFilename(),
                                'url' => $url
                            ]);
                        }
                    }
                }
            }
            array_push($response, $data);
            $message->markAsSeen();

            return $response;
        } catch (Exception $e) {
            \abort(404);
        }
    }
}
