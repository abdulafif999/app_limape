<template>
    <div>
        <Head :title="title" />

        <jet-banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <jet-application-logo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <Popover>
                                    <div class="max-w-7xl mx-auto px-4 sm:px-6">
                                    <div class="flex justify-between items-center border-b-2 border-transparent py-6 sm:justify-start md:space-x-10">
                                        <div class="-mr-2 -my-2 md:hidden">
                                        <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                            <span class="sr-only">Open menu</span>
                                            <MenuIcon class="h-6 w-6" aria-hidden="true" />
                                        </PopoverButton>
                                    </div>
                                    <PopoverGroup as="nav" class="hidden md:flex space-x-10">
                                        <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                            Dashboard
                                        </jet-nav-link>

                                        <jet-nav-link :href="route('penilaian.index')" :active="route().current('penilaian.*')" v-if="showPenilaian" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                            Penilaian
                                        </jet-nav-link>

                                        <jet-nav-link :href="route('user.index')" :active="route().current('user.*')" v-if="$page.props.permission.user.viewAny" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                            User
                                        </jet-nav-link>                                                                 

                                        <Popover class="relative" v-slot="{ open }">
                                            <PopoverButton :class="[open ? 'text-gray-900' : 'text-gray-500', 'group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']" v-if="$page.props.permission.user.viewAny">
                                            <span v-if="$page.props.permission.user.viewAny">Data Tim</span>
                                            <ChevronDownIcon :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']" aria-hidden="true" />
                                            </PopoverButton>

                                            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                                            <PopoverPanel class="absolute z-10 -ml-4 mt-3 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0 lg:left-1/2 lg:-translate-x-1/2">
                                                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                                <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8" v-if="$page.props.permission.user.viewAny">
                                                    <jet-nav-link v-for="item in solutions" :key="item.name" :href="item.href" :active="item.active" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                                    <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                        {{ item.name }}
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                        {{ item.description }}
                                                        </p>
                                                    </div>
                                                    </jet-nav-link>
                                                </div>
                                                </div>
                                            </PopoverPanel>
                                            </transition>
                                        </Popover>

                                        <Popover class="relative" v-slot="{ open }">
                                            <PopoverButton :class="[open ? 'text-gray-900' : 'text-gray-500', 'group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']" v-if="$page.props.permission.user.viewAny">
                                            <span v-if="$page.props.permission.user.viewAny">Data Penilaian</span>
                                            <ChevronDownIcon :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']" aria-hidden="true" />
                                            </PopoverButton>

                                            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                                            <PopoverPanel class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-md sm:px-0">
                                                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                                <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8" v-if="$page.props.permission.user.viewAny">
                                                    <jet-nav-link v-for="item in resources" :key="item.name" :href="item.href" :active="item.active" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                                    <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                        {{ item.name }}
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                        {{ item.description }}
                                                        </p>
                                                    </div>
                                                    </jet-nav-link>
                                                </div>
                                                </div>
                                            </PopoverPanel>
                                            </transition>
                                        </Popover>
                                        </PopoverGroup>
                                    </div>
                                    </div>

                                    <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                                    <PopoverPanel focus class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden" :v-if="$page.props.permission.user.viewAny">
                                        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                                        <div class="pt-5 pb-6 px-5">
                                            <div class="flex items-center justify-between">
                                            <div class="-mr-2">
                                                <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                                <span class="sr-only">Close menu</span>
                                                <XIcon class="h-6 w-6" aria-hidden="true" />
                                                </PopoverButton>
                                            </div>
                                            </div>
                                            <div class="mt-6">
                                            <nav class="grid gap-y-8" v-if="$page.props.permission.user.viewAny">
                                                <jet-nav-link v-for="item in solutions" :key="item.name" :href="item.href" :active="item.active" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                                <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                                <span class="ml-3 text-base font-medium text-gray-900">
                                                    {{ item.name }}
                                                </span>
                                                </jet-nav-link>

                                                <jet-nav-link v-for="item in resources" :key="item.name" :href="item.href" :active="item.active" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
                                                <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                                <span class="ml-3 text-base font-medium text-gray-900">
                                                    {{ item.name }}
                                                </span>
                                                </jet-nav-link>                                                
                                            </nav>
                                            </div>
                                        </div>
                                        <div class="py-6 px-5 space-y-6">
                                            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                                            <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')" class="text-base font-medium text-gray-900 hover:text-gray-700">
                                                Dashboard
                                            </jet-nav-link>

                                            <jet-nav-link :href="route('penilaian.index')" :active="route().current('penilaian.*')" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                                Penilaian
                                            </jet-nav-link>

                                            <jet-nav-link :href="route('user.index')" :active="route().current('user.*')" class="text-base font-medium text-gray-500 hover:text-gray-900" v-if="$page.props.permission.user.viewAny">
                                                Users
                                            </jet-nav-link>                                            
                                            </div>
                                        </div>
                                        </div>
                                    </PopoverPanel>
                                    </transition>
                                </Popover>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <!-- Teams Dropdown -->
                                <jet-dropdown align="right" width="60" v-if="$page.props.jetstream.hasTeamFeatures">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Manage Team
                                                </div>

                                                <!-- Team Settings -->
                                                <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                                                    Team Settings
                                                </jet-dropdown-link>

                                                <jet-dropdown-link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                                                    Create New Team
                                                </jet-dropdown-link>

                                                <div class="border-t border-gray-100"></div>

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <jet-dropdown-link as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </jet-dropdown-link>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <jet-dropdown-link :href="route('profile.show')">
                                            Profile
                                        </jet-dropdown-link>

                                        <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                            API Tokens
                                        </jet-dropdown-link>

                                        <div class="border-t border-gray-100"></div>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                Log Out
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('penilaian.index')" :active="route().current('penilaian.*')">
                            Penilaian
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('user.index')" :active="route().current('user.*')" v-if="$page.props.permission.user.viewAny">
                            Users
                        </jet-responsive-nav-link>
                        
                        <div class="space-x-4 sm:-my-px sm:ml-1 sm:flex justify-between">
                            <Popover class="relative ml-4 mt-3" v-slot="{ open }" v-if="$page.props.permission.user.viewAny">
                                <PopoverButton :class="[open ? 'text-gray-900' : 'text-gray-500', 'group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']" :v-if="$page.props.permission.user.viewAny">
                                    <span>Data Tim</span>
                                    <ChevronDownIcon :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']" aria-hidden="true" />
                                </PopoverButton>

                                <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                                <PopoverPanel class="absolute z-10 -ml-4 mt-3 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0 lg:left-1/2 lg:-translate-x-1/2">
                                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                        <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8" v-if="$page.props.permission.user.viewAny">
                                            <jet-nav-link v-for="item in solutions" :key="item.name" :href="item.href" :active="item.active"  class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                            <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">
                                                    {{ item.name }}
                                                </p>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    {{ item.description }}
                                                </p>
                                            </div>
                                            </jet-nav-link>
                                        </div>
                                    </div>
                                </PopoverPanel>
                                </transition>
                            </Popover>

                            <Popover class="relative ml-4 mt-3" v-slot="{ open }">
                                <PopoverButton :class="[open ? 'text-gray-900' : 'text-gray-500', 'group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']" v-if="$page.props.permission.user.viewAny">
                                    <span v-if="$page.props.permission.user.viewAny">Data Penilaian</span>
                                    <ChevronDownIcon :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']" aria-hidden="true" />
                                </PopoverButton>

                                <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                                    <PopoverPanel class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-md sm:px-0">
                                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                        <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8" v-if="$page.props.permission.user.viewAny">
                                            <jet-nav-link v-for="item in resources" :key="item.name" :href="item.href" :active="item.active"   class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                            <component :is="item.icon" class="flex-shrink-0 h-6 w-6 text-indigo-600" aria-hidden="true" />
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">
                                                    {{ item.name }}
                                                </p>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    {{ item.description }}
                                                </p>
                                            </div>
                                            </jet-nav-link>
                                        </div>
                                    </div>
                                    </PopoverPanel>
                                </transition>
                            </Popover>
                        </div>                  
                                              
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">{{ $page.props.user.name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                API Tokens
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    Log Out
                                </jet-responsive-nav-link>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200"></div>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <jet-responsive-nav-link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link :href="route('teams.create')" :active="route().current('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                                    Create New Team
                                </jet-responsive-nav-link>

                                <div class="border-t border-gray-200"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <jet-responsive-nav-link as="button">
                                            <div class="flex items-center">
                                                <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </jet-responsive-nav-link>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'
    import JetBanner from '@/Jetstream/Banner.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'
    import {
    BookmarkAltIcon,
    CalendarIcon,
    ChartBarIcon,
    CursorClickIcon,
    MenuIcon,
    PhoneIcon,
    PlayIcon,
    RefreshIcon,
    ShieldCheckIcon,
    SupportIcon,
    ViewGridIcon,
    XIcon,
    } from '@heroicons/vue/outline'
    import { ChevronDownIcon } from '@heroicons/vue/solid' 

    const viewAny = '$page.props.permission.user.viewAny'

    const solutions = [
    {
        name: 'Karyawan',
        description: 'Data seluruh karyawan yang ada',
        href: route('karyawan.index'),
        active: route().current('karyawan.*'),
        icon: ChartBarIcon,
        if: viewAny
    },
    {
        name: 'Tim Penilai',
        description: 'Data tim penilai',
        href: route('tim.index'),
        active: route().current('tim.*'),
        icon: ChartBarIcon,
        if:viewAny
    },
    { 
        name: 'Tim 5P/Unit', 
        description: "Data tim 5P/Unit yang dinilai Tim Penilai", 
        href: route('timUnit.index'), 
        active:route().current('timUnit.*'),
        icon: ChartBarIcon,
        if:viewAny,
    },
    ]
    const resources = [
    {
        name: 'Kriteria',
        description: "Kriteria penilaian 5P/Unit setiap tim",
        href: route('kriteria.index'), 
        active:route().current('kriteria.*'),
        icon: ChartBarIcon,
        if:viewAny,
    },
    {
        name: 'Index Kriteria',
        description: 'Index Kriteria masing-masing kriteria yang ada',
        href: route('indexKriteria.index'), 
        active:route().current('indexKriteria.*'),
        icon: ChartBarIcon,
        if:viewAny,
    },
    {
        name: 'Kategori Hasil',
        description: 'Kategori yang didapat tim dengan nilai tertentu',
        href: route('kategoriHasil.index'),
        active: route().current('kategoriHasil.*'),
        icon: ChartBarIcon,
        if:viewAny,
    },
    ]

    export default defineComponent({
        props: {
            title: String,
            showPenilaian:Boolean,
        },

        components: {
            Head,
            JetApplicationMark,
            JetApplicationLogo,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
            Popover,
            PopoverButton,
            PopoverGroup,
            PopoverPanel,
            ChevronDownIcon,
            MenuIcon,
            XIcon,               
        },

        setup() {
            return {
                solutions,
                resources,
            }
        },        

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
            
        }
    })
</script>
