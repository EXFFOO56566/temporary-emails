<!-- Home Section Start -->
<section class="home d-flex align-items-center">
    <div class="effect-wrap">
        <i class="fas fa-plus effect effect-1"></i>
        <i class="fas fa-plus effect effect-2"></i>
        <i class="fas fa-circle-notch effect effect-3"></i>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="home-text">
                    <h1>{{ translate('Mailbox Small Title') }}</h1>
                    <div class="custom-email">
                        <input type="text" class="custom-email-input" value="{{ translate('landing') }}"
                            id="trsh_mail" readonly>
                        <button type="button" data-toggle="tooltip" data-placement="bottom"
                            title="{{ translate('Click To Copy!') }}" data-clipboard-target="#trsh_mail"
                            class="custom-email-botton">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <div class="home-btn">
                        <div class="row align-items-center">
                            <div class="col text-center"><a href="{{ route('home') }}" class="btn btn-1"><i
                                        class="fas fa-redo-alt"></i> {{ translate('Refresh') }}</a></div>
                            <div class="col text-center"><a href="{{ route('change') }}" class="btn btn-1"><i
                                        class="fas fa-pencil-alt"></i> {{ translate('Change') }}</a></div>
                            <div class="col text-center"><a
                                    @if (Cookie::has('count') && Cookie::get('count') >= 5) data-toggle="modal" data-target="#check_bot"
                                    @else
                                    href="{{ route('delete') }}" @endif
                                    class="btn btn-1"><i class="far fa-trash-alt"></i> {{ translate('Delete') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="counter">
                    <span class=" count_ mail_count">
                        <b>{{ translate('Emails Created') }}</b>
                        <em
                            class="css_spirite">{{ $setdata['emails_created'] + $setdata['total_emails_created'] }}</em>
                    </span>
                    <span class=" count_ mail_count">
                        <b>{{ translate('Messages Received') }}</b>
                        <em
                            class="css_spirite">{{ $setdata['messages_received'] + $setdata['total_messages_received'] }}</em>
                    </span>
                </div>
                <input type="hidden" id="captcha-response" name="captcha-response" />
                <p>
                    {{ translate('Mailbox Description') }}
                </p>
            </div>
        </div>
    </div>
</section>

@if (!empty($setdata['INVISIBLE_SITE_KEY']) && !empty($setdata['INVISIBLE_SECRET_KEY']))
    <div id='recaptcha' class="g-recaptcha" data-tabindex="100" data-sitekey="{{ $setdata['INVISIBLE_SITE_KEY'] }}"
        data-callback="myCallback" data-size="invisible">
    </div>

    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback" async defer></script>

        <script>
            window.check_recaptcha = false;

            var onloadCallback = function() {
                grecaptcha.execute();
            };
        </script>
    @endpush
@else
    @push('scripts')
        <script>
            window.check_recaptcha = true;
        </script>
    @endif



    <!-- Home Section End -->
