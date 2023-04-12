<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h4>{{__('Jump To')}}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a href="{{route('settings.general')}}"
                        class="nav-link {{ Request()->segment(3) == "general" ? "active" : '' }}">{{__('General Settings')}}</a></li>
                <li class="nav-item"><a href="{{route('settings.seo')}}" class="nav-link {{ Request()->segment(3) == "seo" ? "active" : '' }}">{{__('SEO')}}</a></li>
                <li class="nav-item"><a href="{{route('settings.ads')}}" class="nav-link {{ Request()->segment(3) == "ads" ? "active" : '' }}">{{__('Ads')}}</a></li>
                <li class="nav-item"><a href="{{route('settings.blog')}}" class="nav-link {{ Request()->segment(3) == "blog" ? "active" : '' }}">{{__('Blog Settings')}}</a></li>
                <li class="nav-item"><a href="{{route('settings.smtp')}}" class="nav-link {{ Request()->segment(3) == "smtp" ? "active" : '' }}">{{__('SMTP')}}</a></li>
                <li class="nav-item"><a href="{{route('languages.index')}}"
                        class="nav-link {{ Request()->segment(3) == "languages" ? "active" : ''
                        }}">{{__('Languages')}}</a></li>
                <li class="nav-item"><a href="{{route('settings.api')}}" class="nav-link {{ Request()->segment(3) == "api" ? "active" : '' }}">{{__('API')}}</a></li>
                <li class="nav-item"><a href="{{route('settings.css.js')}}"
                        class="nav-link {{ Request()->segment(3) == "css_js" ? "active" : '' }}">{{__('Custom CSS &
                        JS')}}</a></li>
                <li class="nav-item"><a href="{{route('settings.license')}}"
                        class="nav-link {{ Request()->segment(3) == "license" ? "active" : '' }}">{{__('License')}}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
