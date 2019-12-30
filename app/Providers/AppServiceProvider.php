<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

#incluido 
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\StoreUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        // Preenche menu
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $id = Auth::id();
            // Obtem as lojas permitidas
            $store_ids = StoreUser::where('user_id', $id)->where('active', 'S')->pluck('store_id')->toArray();
            #dd($store_ids);
            session(['store_ids' => $store_ids]);

            // Obtem menus permitidos e grupos
            $menus = DB::select(" 
                select g.id, g.name grupo, u.name, p.name programa, gu.user_id, gp.program_id, 
                       p.route, p.show_menu, p.icon, g.icon as group_icon
                from groups g
                join group_users gu on gu.group_id = g.id
                join group_programs gp on gp.group_id = g.id
                join users u on u.id = gu.user_id
                join programs p on p.id = gp.program_id
                where gu.active = 'S' and gp.active = 'S'
                and gu.user_id = $id
                order by g.name desc, p.name 
                ");
            $route = substr($_SERVER['PATH_INFO'], 1, 100);

            $program_groups = [];
            $program_routes = [];
            $program_icons = [];
            $group_icons = [];
            $programs = [];
            $icons = [];

            foreach ($menus as $menu) {
                if ($menu->show_menu == 'S')
                    $program_groups[$menu->programa] = $menu->grupo;
                $program_routes[$menu->programa] = $menu->route;
                $program_icons[$menu->programa] = $menu->icon;
                $group_icons[$menu->grupo] = $menu->group_icon;
                $programs[$menu->route] = $menu->programa;
                $icons[$menu->route] = $menu->icon;
            }
            #dd($program_groups);
            // Armazena memoria para depois validar cada mudança de programa
            $programs['home'] = 'home';
            $programs['perfil'] = 'perfil';
            session(['programs' => $programs]);
            session(['icons' => $icons]);

            // Desenha menu
            $anterior = '';
            $submenus = [];
            asort($program_groups);
            foreach ($program_groups as $programa => $grupo) {
                if (empty($anterior))
                    $anterior = $grupo;
                if ($grupo != $anterior) {
                    $event->menu->add(simpleMenu($anterior, $group_icons[$grupo], $submenus));
                    $anterior = $grupo;
                    $submenus = [];
                }
                $submenus[] = simpleSubmenu($programa, $program_icons[$programa], $program_routes[$programa]);
            }
            #dd($program_routes);
            #dd($submenus);
            if (!empty($submenus))
                $event->menu->add(simpleMenu($grupo, $group_icons[$grupo], $submenus));

            // Menu comum a todos usuários 
            $event->menu->add(
                [
                    'text' => 'PERFIL', 'icon' => 'fas fa-fw fa-user',
                    'submenu' => [
                        ['text' => 'Perfil', 'url' => '/perfil', 'icon' => 'fas fa-fw fa-user']
                    ]
                ]
            );
        });
    }
}
