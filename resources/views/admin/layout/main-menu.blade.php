<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        @foreach (config('menu_aside.admin') as $menu)
            @if (count($menu['submenu']) > 0)
                <li class="nav-item">
                    <a class="nav-link @if (isset($page_menu) && $menu['name'] != $page_menu) collapsed @endif"
                        data-bs-target="#forms-{{ $menu['name'] }}" data-bs-toggle="collapse" href="#"
                        @if (isset($page_menu) && $menu['name'] == $page_menu) aria-expanded="true" @endif>
                        <i class="{{ $menu['icon'] }}"></i><span>{{ $menu['title'] }}</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="forms-{{ $menu['name'] }}"
                        class="nav-content @if (isset($page_menu) && $menu['name'] != $page_menu) collapse @else show @endif "
                        data-bs-parent="#sidebar-nav">
                        @foreach ($menu['submenu'] as $submenu)
                            <li>
                                <a @if (!empty($submenu['parameters'])) href="{{ route($submenu['route'], $submenu['parameters']) }}" @else href="{{ route($submenu['route']) }}" @endif
                                    class="@if (isset($page_sub) && $submenu['name'] == $page_sub) active @endif">
                                    <i style="{{ isset($submenu['icon']) && $submenu['icon'] ? 'font-size: 13px' : '' }}"
                                        class="{{ isset($submenu['icon']) && $submenu['icon'] ? $submenu['icon'] : 'bi bi-circle' }}"></i><span>{{ $submenu['title'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                @if (!empty($menu['route']))
                    <li class="nav-item">
                        <a class="nav-link @if (isset($page_menu) && $menu['name'] != $page_menu) collapsed @endif"
                            @if (!empty($menu['parameters'])) href="{{ route($menu['route'], $menu['parameters']) }}" @else href="{{ route($menu['route']) }}" @endif>
                            <i class=" {{ $menu['icon'] }}"></i>
                            <span>{{ $menu['title'] }}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link @if (isset($page_menu) && $menu['name'] != $page_menu) collapsed @endif" href="#">
                            <i class=" {{ $menu['icon'] }}"></i>
                            <span>{{ $menu['title'] }}</span>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</aside>
