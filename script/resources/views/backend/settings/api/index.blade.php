@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{route('settings')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>{{__('API')}}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></div>
      <div class="breadcrumb-item active"><a href="{{route('settings')}}">{{__('Settings')}}</a></div>
      <div class="breadcrumb-item">{{__('API')}}</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">{{__('All About API')}}</h2>
    <p class="section-lead">
      {{__('You can adjust all API here')}}
    </p>

    <div id="output-status"></div>
    <div class="row">
      @include('layouts.setting')
      <div class="col-md-8">
        <div class="card" id="settings-card">
            @csrf
            <div class="card-header">
              <h4>{{__('API')}}</h4>
            </div>
            <div class="card-body">
                <div class="form-group row align-items-center">
                    <label for="site-title" class="form-control-label col-sm-3 text-md-right">{{__('API KEY')}}</label>
                    <div class="col-sm-6 col-md-9">
                      <input type="text" readonly name="api" class="form-control" value="{{$setting['key_api']}}">
                    </div>
                  </div>
            </div>
        </div>

          <div class="card" id="settings-card">
            @csrf
            <div class="card-header">
              <h4>{{__('API Method Listing')}}</h4>
            </div>
            <div class="card-body">
                <section id="domains">
                    <h4>List Domains</h4>
                    <p>Get the current list of available domains.</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <span class="badge badge-success">GET </span> 
                            <strong>https://yourdomain.com/api/domains/{apikey}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{apikey} - Your API Key</p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#DomainsResponse" 
                        aria-expanded="false" aria-controls="DomainsResponse">Example Response</button>
                      <div class="row mt-3">
                        <div class="col">
                          <div class="collapse multi-collapse" id="DomainsResponse">
                            <div class="log" style="display: block;">
<pre id="log_info"><div class="success">{
    "status": "success",
    "data": {
        "domains": {
            "1": "site1.com",
            "2": "site2.com",
            "3": "site3.com"
        }
    }
}
</div></pre>
</div>

                          </div>
                        </div>
                      </div>
                </section>

                <section id="create_email" class="mt-4">
                    <h4>Create Email</h4>
                    <p>Generate a unique email token</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <span class="badge badge-danger">POST </span> 
                            <strong>https://yourdomain.com/api/email/create/{apikey}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{apikey} - Your API Key</p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#create_email_Response" 
                        aria-expanded="false" aria-controls="create_email_Response">Example Response</button>
                      <div class="row mt-3">
                        <div class="col">
                          <div class="collapse multi-collapse" id="create_email_Response">
                            <div class="log" style="display: block;">
<pre id="log_info"><div class="success">{
    "status": "success",
    "data": {
        "email": "email@domain.com",
        "email_token": "eyJpdiI6IlB2MzRrQkthcGpmZjFRVTB1T0RKd3c9PSIsInZhbHVlIjoiMHlzME9CaG1kTm5KZEZOS2lPU0c3M0hwSlFEd3NGRmY3TFVhN0JVRXp0cz0iLCJtYWMiOiJlZWNjNGY2MDg0Yjk3MjkzNzJjNTNiOTk5NDhmYmI0OTE0MGRhOTA4YWQwOGU1ZTRmNzVlY2QzZDFlNjQ2NjE4In0=",
        "deleted_in": "2022-12-02 20:38:13"
    }
}</div></pre>
</div>

                          </div>
                        </div>
                      </div>
                </section>

                <section id="chnage_email" class="mt-4">
                    <h4>Change Email</h4>
                    <p>Generate a custom email token</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <span class="badge badge-danger">POST </span> 
                            <strong>https://yourdomain.com/api/email/change/{email_token}/{username}/{domain}/{apikey}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{email_token} - The old email token you want to change</p>
                    <p>{username} - Your custom username or email ID</p>
                    <p>{domain} - Your custom domain</p>
                    <p>{apikey} - Your API Key</p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#chnage_email_Response" 
                        aria-expanded="false" aria-controls="chnage_email_Response">Example Response</button>
                      <div class="row mt-3">
                        <div class="col">
                          <div class="collapse multi-collapse" id="chnage_email_Response">
                            <div class="log" style="display: block;">
<pre id="log_info"><div class="success">{
    "status": "success",
    "data": {
        "email": "email@domain.com",
        "email_token": "eyJpdiI6IlB2MzRrQkthcGpmZjFRVTB1T0RKd3c9PSIsInZhbHVlIjoiMHlzME9CaG1kTm5KZEZOS2lPU0c3M0hwSlFEd3NGRmY3TFVhN0JVRXp0cz0iLCJtYWMiOiJlZWNjNGY2MDg0Yjk3MjkzNzJjNTNiOTk5NDhmYmI0OTE0MGRhOTA4YWQwOGU1ZTRmNzVlY2QzZDFlNjQ2NjE4In0=",
        "deleted_in": "2022-12-02 20:38:13"
    }
}</div></pre>
</div>

                          </div>
                        </div>
                      </div>
                </section>


                <section id="delete_email" class="mt-4">
                    <h4>Delete Email</h4>
                    <p>Delete the current email and create a new one</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <span class="badge badge-danger">POST </span> 
                            <strong>https://yourdomain.com/api/email/delete/{email_token}/{apikey}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{email_token} - The email token you want to delete</p>
                    <p>{apikey} - Your API Key</p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#delete_email_Response" 
                        aria-expanded="false" aria-controls="delete_email_Response">Example Response</button>
                      <div class="row mt-3">
                        <div class="col">
                          <div class="collapse multi-collapse" id="delete_email_Response">
                            <div class="log" style="display: block;">
<pre id="log_info"><div class="success">{
    "status": "success",
    "data": {
        "email_token": "eyJpdiI6IlB2MzRrQkthcGpmZjFRVTB1T0RKd3c9PSIsInZhbHVlIjoiMHlzME9CaG1kTm5KZEZOS2lPU0c3M0hwSlFEd3NGRmY3TFVhN0JVRXp0cz0iLCJtYWMiOiJlZWNjNGY2MDg0Yjk3MjkzNzJjNTNiOTk5NDhmYmI0OTE0MGRhOTA4YWQwOGU1ZTRmNzVlY2QzZDFlNjQ2NjE4In0=",
        "deleted_in": "2022-12-02 20:38:13"
    }
}</div></pre>
</div>

                          </div>
                        </div>
                      </div>
                </section>



                <section id="messages_email" class="mt-4">
                    <h4>Fetch Messages</h4>
                    <p>Get email messages of the provided Email Token</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <span class="badge badge-success">GET </span> 
                            <strong>https://yourdomain.com/api/messages/{email_token}/{apikey}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{email_token} - Your email token</p>
                    <p>{apikey} - Your API Key</p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#messages_email_Response" 
                        aria-expanded="false" aria-controls="messages_email_Response">Example Response</button>
                      <div class="row mt-3">
                        <div class="col">
                          <div class="collapse multi-collapse" id="messages_email_Response">
                            <div class="log" style="display: block;">
<pre id="log_info"><div class="success">{
    "status": "success",
    "data": {
        "mailbox": "qsirrsr8460@site.com",
        "messages": [
            {
                "subject": "test 2",
                "is_seen": false,
                "from": "Ramos Kelly",
                "from_email": "ramoskelly@gmail.com",
                "receivedAt": "2022-12-02 20:50:53",
                "id": "x6zQW58YB0oPoqewykXdo32S",
                "attachments": [],
                "content": "content html or text "
            },
            {
                "subject": "subject",
                "is_seen": true,
                "from": "Diaz",
                "from_email": "diaz202@gmail.com",
                "receivedAt": "2022-12-02 20:50:33",
                "id": "286J5Nvyk047VZORpBwGPzoQ",
                "attachments": [
                    {
                        "file": "file.png",
                        "url": "http://site.com/download/286J5Nvyk047VZORpBwGPzoQ/file.png"
                    }
                ],
                "content": "content html or text"
            }
        ]
    }
}</div></pre>
</div>

                          </div>
                        </div>
                      </div>
                </section>




                <section id="message_email" class="mt-4">
                    <h4>Fetch Message</h4>
                    <p>Get message of the provided message ID</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <span class="badge badge-success">GET </span> 
                            <strong>https://yourdomain.com/api/message/{message_id}/{apikey}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{message_id} - The ID of the message you want to fetch</p>
                    <p>{apikey} - Your API Key</p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#message_email_Response" 
                        aria-expanded="false" aria-controls="message_email_Response">Example Response</button>
                      <div class="row mt-3">
                        <div class="col">
                          <div class="collapse multi-collapse" id="message_email_Response">
                            <div class="log" style="display: block;">
<pre id="log_info"><div class="success">{
    "status": "success",
    "data": [
        {
            "subject": "subject",
            "is_seen": true,
            "from": "Diaz",
            "from_email": "diaz202@gmail.com",
            "receivedAt": "2022-12-02 20:50:33",
            "id": "286J5Nvyk047VZORpBwGPzoQ",
            "attachments": [
                {
                    "file": "file.png",
                    "url": "http://site.com/download/286J5Nvyk047VZORpBwGPzoQ/file.png"
                }
            ],
            "content": "content html or text"
        }
    ]
}</div></pre>
</div>

                          </div>
                        </div>
                      </div>
                </section>


                <section id="delete_message_email" class="mt-4">
                    <h4>Delete Message</h4>
                    <p>Delete a specific email message by message ID</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <span class="badge badge-danger">POST </span> 
                            <strong>https://yourdomain.com/api/message/delete/{message_id}/{apikey}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{message_id} - The ID of the message you want to Detele</p>
                    <p>{apikey} - Your API Key</p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#delete_message_email_Response" 
                        aria-expanded="false" aria-controls="delete_message_email_Response">Example Response</button>
                      <div class="row mt-3">
                        <div class="col">
                          <div class="collapse multi-collapse" id="delete_message_email_Response">
                            <div class="log" style="display: block;">
<pre id="log_info"><div class="success">{
    "status": "success",
    "message": "the message has been deleted"
}</div></pre>
</div>
                          </div>
                        </div>
                      </div>
                </section>


                <section id="delete_message_email" class="mt-4">
                    <h4>Token to email in your website</h4>
                    <p>Send your visitors to a site with a token to create the same email</p>
                    <div class="alert alert-light" role="alert">
                        <h6 class="m-0">
                            <strong>https://yourdomain.com/token/{email_token}</strong>
                        </h6>
                    </div>
                    <h4>Parameters</h4>
                    <p>{email_token} - Your email token</p>
                </section>

            </div>
          </div>
      </div>
    </div>
  </div>
</section>
@endsection

