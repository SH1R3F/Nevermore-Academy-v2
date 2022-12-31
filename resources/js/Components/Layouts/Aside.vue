<script setup></script>

<template>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
        id="sidenav-main"
    >
        <div class="sidenav-header">
            <i
                class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true"
                id="iconSidenav"
            ></i>
            <Link class="navbar-brand m-0" href="/">
                <img
                    :src="
                        $page.props.authUser.avatar || '/assets/img/logo.webp'
                    "
                    class="navbar-brand-img h-100"
                    alt="Avatar"
                />
                <span class="ms-1 font-weight-bold">
                    {{ $page.props.APP_NAME }}
                </span>
            </Link>
        </div>
        <hr class="horizontal dark mt-0" />
        <div
            class="collapse navbar-collapse h-auto w-auto"
            id="sidenav-collapse-main"
        >
            <ul class="navbar-nav">
                <li class="nav-item">
                    <Link
                        class="nav-link"
                        :class="{ active: $page.component === 'Dashboard' }"
                        href="/"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-tv-2 text-primary text-sm opacity-10"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </Link>
                </li>

                <li
                    class="nav-item"
                    v-if="$page.props.authUser.role == 'superadmin'"
                >
                    <Link
                        class="nav-link"
                        :class="{
                            active: $page.url.startsWith('push-notifications'),
                        }"
                        href="/push-notifications/create"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-tv-2 text-primary text-sm opacity-10"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1"
                            >Create a notification</span
                        >
                    </Link>
                </li>

                <li
                    class="nav-item"
                    v-if="$page.props.authUser.can.viewAny_role"
                >
                    <Link
                        class="nav-link"
                        :class="{
                            active: $page.url.startsWith('roles'),
                        }"
                        href="/roles"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-user-run text-primary text-sm opacity-10"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">Roles</span>
                    </Link>
                </li>
                <li
                    class="nav-item"
                    v-if="$page.props.authUser.can.viewAny_user"
                >
                    <Link
                        class="nav-link"
                        :class="{
                            active: $page.url.startsWith('users'),
                        }"
                        href="/users"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-user-run text-primary text-sm opacity-10"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">Users</span>
                    </Link>
                </li>
                <li
                    class="nav-item"
                    v-if="$page.props.authUser.can.viewAny_assignment"
                >
                    <Link
                        class="nav-link"
                        :class="{
                            active: $page.url.startsWith('assignments'),
                        }"
                        href="/assignments"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-user-run text-primary text-sm opacity-10"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">Assignments</span>
                    </Link>
                </li>
                <li
                    class="nav-item"
                    v-if="$page.props.authUser.can.viewAny_submission"
                >
                    <Link
                        class="nav-link"
                        :class="{
                            active: $page.url.startsWith('submissions'),
                        }"
                        href="/submissions"
                    >
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i
                                class="ni ni-user-run text-primary text-sm opacity-10"
                            ></i>
                        </div>
                        <span class="nav-link-text ms-1">Submissions</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>
