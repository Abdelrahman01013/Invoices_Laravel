<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/logo.png') }}"
                        class="logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="dark-logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ url('assets/img/profile/' . auth()->user()->img) }}" class="logo-2" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img src="{{ URL::asset('assets/img/brand/favicon.png') }}"
                        class="dark-logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>

        </div>
        <div class="main-header-right">
            <ul class="nav">
                <li class="">
                    <div class="dropdown  nav-itemd-none d-md-flex">


                    </div>
                </li>
            </ul>
            <div class="nav nav-item  navbar-nav-right ml-auto">
                <div class="nav-link" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>



                @can('الاشعارات')


                    <div class="dropdown nav-item main-header-notification">
                        <a class="new nav-link" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-bell">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg><span class=" pulse"></span></a>
                        <div class="dropdown-menu">
                            <div class="menu-header-content bg-primary text-right">
                                <div class="d-flex">
                                    <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الأشعارات</h6>
                                    <span class="badge badge-pill badge-warning mr-auto my-auto float-left">
                                        <a href="{{ route('read_all') }}"> تعين الكل كمقروء</a>

                                    </span>
                                </div>
                                <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
                                <h2 id="count"> {{ auth()->user()->unreadNotifications->count() }} </h2>
                                </p>
                            </div>
                            <div class="main-notification-list Notification-scroll">
                                <div id="notif">
                                    @foreach (auth()->user()->unreadNotifications as $not)
                                        @php
                                            $invoice = App\Models\Invoivices::select('invoice_number')
                                                ->where('id', $not->data['inv_id'])
                                                ->first();
                                        @endphp
                                        <a class="d-flex p-3 border-bottom"
                                            href="{{ url('markAsRead', ['v_id' => $not->data['inv_id'], 'n_id' => $not->id]) }}">
                                            <div class="notifyimg bg-pink">
                                                <i class="la la-file-alt text-white"></i>
                                            </div>

                                            <div class="mr-3">
                                                <h5 class="notification-label mb-1">{{ $not->data['title'] }}
                                                    {{ $invoice->invoice_number ?? '' }}
                                                    <br>
                                                    {{ $not->data['user_create'] }}
                                                </h5>
                                                <div class="notification-subtext"> {{ $not->created_at->format('Y-m-d') }}

                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>







                            </div>
                            <div class="dropdown-footer">

                                <a class="modal-effect dropdown-item" data-effect="" data-toggle="modal" href="#notificion">
                                    عرض جميع الأشعارات </a>
                            </div>
                        </div>
                    </div>

                @endcan

                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-maximize">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href=""><img alt=""
                            src="{{ url('assets/img/profile/' . auth()->user()->img) }}"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt=""
                                        src="{{ url('assets/img/profile/' . auth()->user()->img) }}" class="">
                                </div>
                                <div class="mr-3 my-auto">
                                    <h6>{{ auth()->user()->name }}</h6><span>{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ url('dashboard') }}"><i
                                class="bx bx-user-circle"></i>الملف
                            الشحصي</a>
                        <a class="dropdown-item" href="profile"><i class="bx bx-cog"></i> تعديل الملف الشخصي</a>
                        {{-- <a class="dropdown-item" href=""> --}}

                        <a class="modal-effect dropdown-item" data-effect="" data-toggle="modal" href="#profile">

                            <i class="bx bxs-inbox"></i>
                            الصوره الشخصيه
                        </a>


                        {{-- </a> --}}
                        <a class="dropdown-item" href=""><i class="bx bx-envelope"></i>الرسائل</a>
                        {{-- <a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> Account Settings</a> --}}

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                class="bx bx-log-out"></i>تسجيل خروج</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal effects -->
<div class="modal" id="profile">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modal Header</h6><button aria-label="Close" class="close"
                    data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <img src="{{ url('assets/img/profile/' . auth()->user()->img) }}" width="100%" height="100%">
            <form action="{{ route('add_img.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-center">
                    <label for="img" class="text-center">

                        <li class="icons-list-item"><i class="ti-arrow-down"></i></li>

                        اختر صوره
                    </label>
                </div>
                <input type="file" name="img" id="img" hidden>

                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit">تغيير</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- notificition --}}
<div class="modal" id="notificion">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">الأشعارات</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>


            @php
                $notifications = auth()
                    ->user()
                    ->notifications()
                    ->orderBy('read_at', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            @foreach ($notifications as $not)
                @php
                    $invoice = App\Models\Invoivices::select('invoice_number')
                        ->where('id', $not->data['inv_id'])
                        ->first();
                @endphp
                <a class="d-flex p-3 border-bottom"
                    href="{{ url('markAsRead', ['v_id' => $not->data['inv_id'], 'n_id' => $not->id]) }}">
                    <div class="notifyimg ">
                        {{-- <i class="la la-file-alt text-white"></i> --}}
                        @if ($not->read_at == null)
                            <li class="icons-list-item "><i class="far fa-eye-slash"></i></li>
                        @else
                            <li class="icons-list-item "><i class="far fa-eye"></i></li>
                        @endif
                    </div>

                    <div class="mr-">

                        <h5 class="notification-label mb-1 ">{{ $not->data['title'] }}
                            {{ $invoice->invoice_number ?? '' }}
                            <br>
                            {{ $not->data['user_create'] }}
                        </h5>
                        <div class="notification-subtext"> {{ $not->created_at->format('Y-m-d') }}

                        </div>

                    </div>





                </a>
            @endforeach


            <div class="modal-footer">
                <a class="btn ripple btn-danger" type="submit" href="{{ url('delete_notifiction') }}"
                    onclick="return confirm('هل انت متاكد من حزف جميع الأشعارات')">حزف الجميع</a>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إغلاق</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- notificition --}}

<div class="text-center">
    @foreach ($errors->all() as $error)
        <li class="text-danger m-5"> {{ $error }}</li>
    @endforeach
</div>


<!-- End Modal effects-->
