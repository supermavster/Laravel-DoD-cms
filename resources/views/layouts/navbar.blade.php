<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
    <a class="navbar-brand" href="#">
        <img src="{{asset('media/no-img.jpg')}}" width="25" alt="">
        Demo on Demand
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-calendar-day"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="far fa-bell"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-user-circle"></i>
                </a>
            </li>
            <li class="nav-item">
                    <span class="navbar-text">
                        {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}
                    </span>
            </li>
        </ul>
    </div>
</nav>


<nav class="navbar navbar-expand-lg navbar-light bg-light py-0 px-0">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item border text-center">
                <a class="nav-link" href="{{route('home')}}">
                        <span>
                            <i class="fas fa-home fa-2x"></i>
                            <br/>
                            Home
                        </span>
                </a>
            </li>
            <li class="nav-item border text-center">
                <a class="nav-link" href="{{route('users')}}">
                        <span>
                            <i class="fas fa-user-circle fa-2x"></i>
                            <br/>
                            Users
                        </span>
                </a>
            </li>
            <li class="nav-item border text-center">
                <a class="nav-link" href="{{route('demolitions')}}">
                        <span>
                            <i class="fas fa-scroll fa-2x"></i>
                            <br/>
                            Demolition
                        </span>
                </a>
            </li>
            <li class="nav-item border text-center">
                <a class="nav-link" href="{{route('payments')}}">
                        <span>
                            <i class="fas fa-donate fa-2x"></i>
                            <br/>
                            Payments
                        </span>
                </a>
            </li>
            <li class="nav-item border text-center">
                <a class="nav-link" href="#">
                        <span>
                            <i class="far fa-comment-dots fa-2x"></i>
                            <br/>
                            Notifications
                        </span>
                </a>
            </li>
            <li class="nav-item border text-center">
                <a class="nav-link" href="#">
                        <span>
                            <i class="fas fa-question fa-2x"></i>
                            <br/>
                            Questions
                        </span>
                </a>
            </li>
            <li class="nav-item border text-center">
                <a class="nav-link" href="#">
                        <span>
                            <i class="fas fa-shopping-cart fa-2x"></i>
                            <br/>
                            Advertisers
                        </span>
                </a>
            </li>
        </ul>
    </div>
</nav>
