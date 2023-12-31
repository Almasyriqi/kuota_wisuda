<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="
        {{-- {{ route('home') }} --}}
        ">
            <img alt="Logo"
                src="{{ isset($setting->logo_default) ? asset('storage/' . $setting->logo_default) : asset('assets/images/Logo-Polinema.png') }}"
                class="h-50px app-sidebar-logo-default" />
            <img alt="Logo"
                src="{{ isset($setting->logo_square) ? asset('storage/' . $setting->logo_square) : asset('assets/images/Logo-Polinema.png') }}"
                class="h-30px app-sidebar-logo-minimize" />
        </a>
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                {{-- Dashboard --}}
                <div class="menu-item">
                    <a href="{{route('home')}}" class="menu-link {{ request()->is(['home*']) ? 'active' : '' }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.49935 1.66699H8.33268C8.83268 1.66699 9.16602 2.00033 9.16602 2.50033V8.33366C9.16602 8.83366 8.83268 9.16699 8.33268 9.16699H2.49935C1.99935 9.16699 1.66602 8.83366 1.66602 8.33366V2.50033C1.66602 2.00033 1.99935 1.66699 2.49935 1.66699Z"
                                        fill="#A1A5B7" />
                                    <path
                                        d="M11.6673 1.66699H17.5007C18.0007 1.66699 18.334 2.00033 18.334 2.50033V8.33366C18.334 8.83366 18.0007 9.16699 17.5007 9.16699H11.6673C11.1673 9.16699 10.834 8.83366 10.834 8.33366V2.50033C10.834 2.00033 11.1673 1.66699 11.6673 1.66699Z"
                                        fill="#E3E4EA" />
                                    <path
                                        d="M2.49935 10.833H8.33268C8.83268 10.833 9.16602 11.1663 9.16602 11.6663V17.4997C9.16602 17.9997 8.83268 18.333 8.33268 18.333H2.49935C1.99935 18.333 1.66602 17.9997 1.66602 17.4997V11.6663C1.66602 11.1663 1.99935 10.833 2.49935 10.833Z"
                                        fill="#E3E4EA" />
                                    <path
                                        d="M11.6673 10.833H17.5007C18.0007 10.833 18.334 11.1663 18.334 11.6663V17.4997C18.334 17.9997 18.0007 18.333 17.5007 18.333H11.6673C11.1673 18.333 10.834 17.9997 10.834 17.4997V11.6663C10.834 11.1663 11.1673 10.833 11.6673 10.833Z"
                                        fill="#E3E4EA" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Home</span>
                    </a>
                </div>

                <hr>

                {{-- Data Management --}}
                <div class="menu-item">
                    <div class="menu-content pt-5 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Kelola Data</span>
                    </div>
                </div>
                {{-- Admin --}}
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('wisuda.*') ? 'active' : '' }}" href="
                                    {{ route('wisuda.index') }}
                                    ">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.23851 12.5717C6.12035 10.9845 7.79346 10 9.60927 10H10.3919C12.2078 10 13.8809 10.9845 14.7627 12.5717L16.125 15.0239C16.7422 16.1348 15.9389 17.5 14.6681 17.5H5.33313C4.06232 17.5 3.25904 16.1348 3.8762 15.0239L5.23851 12.5717Z"
                                        fill="#A1A5B7" />
                                    <path
                                        d="M13.3346 5.83333C13.3346 3.99238 11.8423 2.5 10.0013 2.5C8.16035 2.5 6.66797 3.99238 6.66797 5.83333C6.66797 7.67428 8.16035 9.16667 10.0013 9.16667C11.8423 9.16667 13.3346 7.67428 13.3346 5.83333Z"
                                        fill="#E3E4EA" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Wisuda</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('jurusan.*') ? 'active' : '' }}" href="
                                    {{ route('jurusan.index') }}
                                    ">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.7077 15.4378L10.8743 18.1878C10.291 18.4378 9.70768 18.4378 9.12435 18.1878L2.29102 15.4378C1.45768 15.1045 1.45768 13.9378 2.29102 13.6045L3.37434 13.1878L8.54102 15.2711C9.04102 15.4378 9.54102 15.5211 10.041 15.5211C10.541 15.5211 11.041 15.4378 11.541 15.2711L16.7077 13.1878L17.791 13.6045C18.6243 13.9378 18.6243 15.1045 17.7077 15.4378ZM10.8743 13.6878L17.7077 10.9378C18.541 10.6045 18.541 9.43781 17.7077 9.10448L10.8743 6.35449C10.291 6.10449 9.70768 6.10449 9.12435 6.35449L2.29102 9.10448C1.45768 9.43781 1.45768 10.6045 2.29102 10.9378L9.12435 13.6878C9.70768 13.9378 10.3743 13.9378 10.8743 13.6878Z"
                                        fill="#E3E4EA" />
                                    <path
                                        d="M9.20835 9.18783L2.375 6.43783C1.54167 6.10449 1.54167 4.93783 2.375 4.60449L9.20835 1.85449C9.79168 1.60449 10.375 1.60449 10.9583 1.85449L17.7917 4.60449C18.625 4.93783 18.625 6.10449 17.7917 6.43783L10.875 9.18783C10.375 9.43783 9.70835 9.43783 9.20835 9.18783Z"
                                        fill="#A1A5B7" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Jurusan</span>
                    </a>
                </div>
                <hr>
            </div>
        </div>
    </div>
    {{-- <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <form action="
        {{ route('logout') }}
        " method="POST" id="logout-form">
            @csrf
            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-flex flex-center btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click">
                <span class="btn-label">Logout</span> &nbsp;
                <span class="svg-icon btn-icon svg-icon-2 m-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 12h-9.5m7.5 3l3-3l-3-3m-5-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2v-1" />
                    </svg>
                </span>
            </a>
        </form>
    </div> --}}
</div>