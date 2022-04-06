@extends('Admin.Views.sidebar-secondary')

@section('sidebar-title', 'Centro de seguridad')

@section('sidebar-content')
    @can('access', 'auth.organizations.list')
        <x-sidebar.card title="{{ __('messages.companiesSecondarySidebar') }}" :is-active="Sidebar::isCurrentMenu('menuAuthOrganizations', $admin_info->openSidebars ?? null)" >
            @can('access','auth.organizations.create')
                <x-sidebar.button :url="route('auth.organizations.create')" color="bg-primary" >
                    {{ __('messages.newApplicantSecondarySidebarButton') }}
                </x-sidebar.button>
            @endcan
            @can('access','auth.branches.create')
                <x-sidebar.button :url="route('auth.branches.create')" color="bg-primary" >
                    {{ __('messages.newAddresseesSecondarySidebarButton') }}

                </x-sidebar.button>
            @endcan
            <x-sidebar.nav>
                <x-sidebar.header>{{ __('messages.listsAddresseesSecondarySidebar') }}</x-sidebar.header>
                <x-sidebar.item :is-active="request()->routeIs('auth.organizations.*')" :url="route('auth.organizations.list')" icon="icon-city" title="{{ __('messages.applicantsSecondarySidebarList') }}" >
                    {{ __('messages.applicantManagementSecondarySidebarList') }}
                </x-sidebar.item>
                <x-sidebar.item :is-active="request()->routeIs('auth.branches.*')" :url="route('auth.branches.list')" icon="icon-office" title="{{ __('messages.addresseesSecondarySidebarList') }}" >
                    {{ __('messages.addresseeManagementSecondarySidebarList') }}
                </x-sidebar.item>
            </x-sidebar.nav>
        </x-sidebar.card>
    @endcan
    @can('access', 'auth.users.list')
        <x-sidebar.card title="{{ __('messages.usersSecondarySidebar') }}" :is-active="Sidebar::isCurrentMenu('menuAuthUser', $admin_info->openSidebars ?? null)" >
            @can('access','people.persons.create')
                <x-sidebar.button :url="route('people.persons.create')" color="bg-primary" >
                    {{ __('messages.newPersonSecondarySidebarButton') }}
                </x-sidebar.button>
            @endcan
            @can('access', 'auth.users.create')
                <x-sidebar.button :url="route('auth.users.create')" color="bg-primary" >
                    {{ __('messages.newUserSecondarySidebarButton') }}
                </x-sidebar.button>
            @endcan
            <x-sidebar.nav>
                <x-sidebar.header>{{ __('messages.listsUserSecondarySidebar') }}</x-sidebar.header>
                <x-sidebar.item :is-active="request()->routeIs('people.persons.*')" :url="route('people.persons.list')" icon="mi-contacts" title="{{ __('messages.peopleSecondarySidebarList') }}" >
                    {{ __('messages.peopleSecondarySidebarList') }}
                </x-sidebar.item>
                <x-sidebar.item :is-active="request()->routeIs('auth.users.*')" :url="route('auth.users.list')" icon="mi-account-circle" title="{{ __('messages.usersSecondarySidebarList') }}" >
                    {{ __('messages.usersSecondarySidebarList') }}
                </x-sidebar.item>
            </x-sidebar.nav>
        </x-sidebar.card>
    @endcan
    @can('access', 'auth.roles.list')
        <x-sidebar.card
            title="{{ __('messages.rolesSecondarySidebar') }}"
            :is-active="Sidebar::isCurrentMenu('menuAuthRole', $admin_info->openSidebars ?? null)"
        >
            @can('access', 'auth.roles.create')
                <x-sidebar.button
                    :url="route('auth.roles.create')"
                    color="bg-primary"
                >
                    {{ __('messages.newRoleSecondarySidebarButton') }}
                </x-sidebar.button>
            @endcan
            <x-sidebar.nav>
                <x-sidebar.header>{{ __('messages.listsRolesSecondarySidebar') }}</x-sidebar.header>
                <x-sidebar.item
                    :is-active="request()->routeIs('auth.roles.*')"
                    :url="route('auth.roles.list')"
                    icon="mi-contact-mail"
                    title="{{ __('messages.rolesSecondarySidebarList') }}"
                >
                    {{ __('messages.rolesSecondarySidebarList') }}
                </x-sidebar.item>
            </x-sidebar.nav>
        </x-sidebar.card>
    @endcan
    @can('access', 'auth.perms.list')
        <x-sidebar.card
            title="{{ __('messages.permissionsSecondarySidebar') }}"
            :is-active="Sidebar::isCurrentMenu('menuAuthPerm', $admin_info->openSidebars ?? null)"
        >
            <x-sidebar.nav>
                <x-sidebar.header>{{ __('messages.listsPermissionsSecondarySidebar') }}</x-sidebar.header>
                @can('access', 'auth.perms.list')
                    <x-sidebar.item
                        :is-active="request()->routeIs('auth.perms.*')"
                        :url="route('auth.perms.list')"
                        icon="mi-security"
                        title="{{ __('messages.permissionsSecondarySidebarList') }}"
                    >
                        {{ __('messages.permissionsSecondarySidebarList') }}
                    </x-sidebar.item>
                @endcan
            </x-sidebar.nav>
        </x-sidebar.card>
    @endcan
    @can('access', 'geo.countries.list')
        <x-sidebar.card
            title="{{ __('messages.geographicInformationSecondarySidebar') }}"
            :is-active="Sidebar::isCurrentMenu('menuConfGeo', $admin_info->openSidebars ?? null)"
        >
            <x-sidebar.nav>
                <x-sidebar.header>{{ __('messages.listsGeographicInformationSecondarySidebar') }}</x-sidebar.header>
                <x-sidebar.item
                    :is-active="request()->routeIs('geo.countries.*')"
                    :url="route('geo.countries.list')"
                    icon="mi-pin-drop"
                    title="{{ __('messages.countriesSecondarySidebarList') }}"
                >
                    {{ __('messages.countriesSecondarySidebarList') }}
                </x-sidebar.item>
                @can('access', 'geo.regions.list')
                    <x-sidebar.item
                        :is-active="request()->routeIs('geo.regions.*')"
                        :url="route('geo.regions.list')"
                        icon="mi-pin-drop"
                        title="{{ __('messages.provincesSecondarySidebarList') }}"
                    >
                        {{ __('messages.provincesSecondarySidebarList') }}
                    </x-sidebar.item>
                @endcan
                @can('access', 'geo.cities.list')
                    <x-sidebar.item
                        :is-active="request()->routeIs('geo.cities.*')"
                        :url="route('geo.cities.list')"
                        icon="mi-pin-drop"
                        title="{{ __('messages.citiesSecondarySidebarList') }}"
                    >
                        {{ __('messages.citiesSecondarySidebarList') }}
                    </x-sidebar.item>
                @endcan
            </x-sidebar.nav>
        </x-sidebar.card>
    @endcan
    @can('access', 'auditory.list')
        <x-sidebar.card
            title="{{ __('messages.auditSecondarySidebar') }}"
            :is-active="Sidebar::isCurrentMenu('menuAuthAuditory', $admin_info->openSidebars ?? null)"
        >
            <x-sidebar.nav>
                <x-sidebar.header>{{ __('messages.listsAuditSecondarySidebar') }}</x-sidebar.header>
                <x-sidebar.item
                    :is-active="request()->routeIs('auditory.*')"
                    :url="route('auditory.list')"
                    icon="mi-assignment"
                    title="{{ __('messages.accessRegisterSecondarySidebarList') }}"
                >
                    {{ __('messages.accessRegisterSecondarySidebarList') }}
                </x-sidebar.item>
            </x-sidebar.nav>
        </x-sidebar.card>
    @endcan
@endsection
