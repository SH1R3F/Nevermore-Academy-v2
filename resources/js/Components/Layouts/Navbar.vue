<script setup>
const localize = () => {
    const params = route().params;
    params.locale = params.locale === "ar" ? "en" : "ar";
    window.location = route(route().current(), params);
};
</script>

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
                                $page.props.authUser.name
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
                                    {{ __("Role") }}:
                                    {{ $page.props.authUser.role }}
                                </span>
                            </li>
                            <li>
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="text-sm font-weight-normal mb-1 bg-transparent w-100 text-center py-1 border-0"
                                    type="submit"
                                >
                                    {{ __("Logout") }}
                                </Link>
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
                            <li
                                class="mb-2"
                                v-for="notification in $page.props.authUser
                                    .notifications"
                            >
                                <Link
                                    class="dropdown-item border-radius-md"
                                    :href="notification.data.link"
                                >
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <Link
                                                :href="
                                                    route(
                                                        'notifications.read',
                                                        notification.id
                                                    )
                                                "
                                                method="post"
                                                as="button"
                                                class="me-3 btn btn-default"
                                            >
                                                read
                                            </Link>
                                        </div>
                                        <div
                                            class="d-flex flex-column justify-content-center"
                                        >
                                            <h6
                                                class="text-sm font-weight-normal mb-1"
                                            >
                                                {{ notification.data.message }}
                                            </h6>
                                            <p
                                                class="text-xs text-secondary mb-0"
                                            >
                                                <i class="fa fa-clock me-1"></i>
                                                {{ notification.created_at }}
                                            </p>
                                        </div>
                                    </div>
                                </Link>
                            </li>
                            <li
                                v-if="
                                    !$page.props.authUser.notifications.length
                                "
                            >
                                <a class="dropdown-item border-radius-md">
                                    <h6 class="text-sm font-weight-normal mb-1">
                                        You are up to date. New notifications
                                        will appear here
                                    </h6>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Site language -->
                    <li
                        class="nav-item dropdown pe-2 d-flex align-items-center mx-2"
                    >
                        <a
                            href="#"
                            class="nav-link text-white p-0"
                            @click.prevent="localize()"
                        >
                            <i class="fa fa-flag me-sm-1"></i>
                            <span class="d-sm-inline d-none">{{
                                route().params.locale === "ar"
                                    ? "English"
                                    : "العربية"
                            }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <template v-if="!$page.props.authUser.verified">
        <div class="alert alert-info" role="alert">
            <h6 class="m-0">
                {{
                    __(
                        "You didn't verify your email address and you won't be able to receive any email notification from us."
                    )
                }}
                <br />
                {{ __("Please click on the link sent to your email or") }}

                <Link
                    class="btn btn-primary btn-sm"
                    :href="route('verification.send')"
                    as="button"
                    method="post"
                >
                    {{ __("Resend verification email") }}
                </Link>
            </h6>
        </div>
        <div
            class="alert alert-info"
            role="alert"
            v-if="$page.props.flash.status === 'verification-link-sent'"
        >
            {{ __("Email verification has been sent to your email.") }}
        </div>
    </template>
    <div
        class="alert alert-success"
        role="alert"
        v-if="
            $page.props.flash.status &&
            $page.props.flash.status !== 'verification-link-sent'
        "
    >
        {{ $page.props.flash.status }}
    </div>
</template>
