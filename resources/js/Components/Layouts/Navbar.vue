<template>
    <!-- Navbar -->
    <nav
        class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl"
        id="navbarBlur"
        data-scroll="false"
    >
        <div class="container-fluid py-1 px-3">
            <div
                class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4"
                id="navbar"
            >
                <ul class="ms-md-auto navbar-nav justify-content-end">
                    <li
                        class="nav-item d-xl-none ps-3 d-flex align-items-center"
                    >
                        <a
                            href="javascript:;"
                            class="nav-link text-white p-0"
                            id="iconNavbarSidenav"
                        >
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                        </a>
                    </li>
                    <!-- User information -->
                    <li
                        class="nav-item dropdown pe-2 d-flex align-items-center mx-2"
                    >
                        <a
                            href="javascript:;"
                            class="nav-link text-white p-0"
                            id="userMenuBar"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">{{
                                "auth()->user()->name"
                            }}</span>
                        </a>
                        <ul
                            class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                            style="top: 0.5rem !important"
                            aria-labelledby="userMenuBar"
                        >
                            <li>
                                <span
                                    class="text-sm font-weight-normal mb-1 d-block text-center text-muted"
                                >
                                    Role: {{ "auth()->user()->role?->name" }}
                                </span>
                            </li>
                            <li>
                                <form method="POST" action="#" id="logoutForm">
                                    <button
                                        class="text-sm font-weight-normal mb-1 bg-transparent w-100 text-center py-1 border-0"
                                        type="submit"
                                    >
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item dropdown pe-2 d-flex align-items-center"
                    >
                        <a
                            href="javascript:;"
                            class="nav-link text-white p-0"
                            id="dropdownMenuButton"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="fa fa-bell cursor-pointer"></i>
                        </a>
                        <ul
                            class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton"
                            style="top: 0.5rem !important"
                        >
                            <li class="mb-2" v-for="i in []">
                                <a
                                    class="dropdown-item border-radius-md"
                                    href="#"
                                >
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <form action="#" method="POST">
                                                <button
                                                    type="submit"
                                                    class="me-3 btn btn-default"
                                                >
                                                    read
                                                </button>
                                            </form>
                                        </div>
                                        <div
                                            class="d-flex flex-column justify-content-center"
                                        >
                                            <h6
                                                class="text-sm font-weight-normal mb-1"
                                            >
                                                $notification->data['message']
                                            </h6>
                                            <p
                                                class="text-xs text-secondary mb-0"
                                            >
                                                <i class="fa fa-clock me-1"></i>
                                                $notification->created_at->diffForHumans()
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        You are up to date. New notifications
                                        will appear here
                                    </h6>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="alert alert-info" role="alert" v-if="true">
        <h6 class="m-0">
            You didn't verify your email address and you won't be able to
            receive any email notification from us.
            <br />
            Please click on the link sent to your email or
            <form class="d-inline" method="POST" action="#">
                <button type="submit" class="btn btn-primary btn-sm">
                    Resend verification email
                </button>
            </form>
        </h6>
    </div>
    <div class="alert alert-info" role="alert" v-if="true">
        Email verification has been sent to your email.
    </div>
</template>
