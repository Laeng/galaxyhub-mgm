<?php

namespace App\View\Components\Layout\Galaxyhub;

use App\Enums\RoleType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class Header extends Component
{
    public string $parentClass;
    public string $class;
    public string $logoHexCode;
    public string $logoTextClass;
    public string $menuTextClass;
    public string $websiteName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parentClass = '', $class = '', $logoHexCode = '#000000', $logoTextClass = '', $menuTextClass = 'text-gray-700', $websiteName = '')
    {
        $this->parentClass = $parentClass;
        $this->class = $class;
        $this->logoHexCode = $logoHexCode;
        $this->logoTextClass = $logoTextClass;
        $this->menuTextClass = $menuTextClass;
        $this->websiteName = $websiteName;
    }

    public function render(): View
    {
        $user = Auth::user();
        $menu = Menu::new();

        if (is_null($user) || mb_strtolower($this->websiteName) !== 'mgm lounge')
        {
            $menu = $menu->add(Link::toRoute('app.index', 'MGM Lounge'));
        }
        else
        {
            $roles = $user->where('id', $user->id)->with('roles')->get();

            if (!is_null($roles) && count($roles->first()->roles) > 0)
            {
                $role = $roles->first()->roles;
                $roleType = $role->first()->name;

                if (!$user->isBanned() && in_array($roleType, [RoleType::MEMBER->name, RoleType::MAKER1->name, RoleType::MAKER2->name, RoleType::ADMIN->name]))
                {
                    //멤버 이상.

                    if ($roleType !== RoleType::MEMBER->name)
                    {
                        $menu = $menu->submenu("<a href='#'>미션</a>", function (Menu $menu) {
                            $menu = $menu->add(Link::toRoute('mission.index', '미션 목록'));
                            $menu = $menu->add(Link::toRoute('mission.new', '새로 만들기'));
                        });
                    }
                    else
                    {
                        $menu = $menu->add(Link::toRoute('mission.index', '미션'));
                    }

                    $menu = $menu->add(Link::toRoute('updater.index', '업데이터'));
                    $menu = $menu->add(Link::toRoute('account.pause', '장기 미접속'));

                    if ($roleType === RoleType::ADMIN->name)
                    {
                        $menu = $menu->submenu("<a href='#'>관리</a>", function (Menu $menu) {
                            $menu = $menu->add(Link::toRoute('admin.user.index', '회원 목록'));
                            $menu = $menu->add(Link::toRoute('admin.application.index', '가입 신청자 목록'));
                        });
                    }

                    $menu = $menu->add(Link::toRoute('account.me', '내 정보'));
                }
                else
                {
                    $menu = $menu->add(Link::toRoute('account.leave', '데이터 삭제'));
                }

                $menu = $menu->add(Link::toRoute('auth.logout', '로그아웃'));
            }
            else
            {
                $menu = $menu->add(Link::toRoute('welcome', '돌아가기'));
            }
        }

        $menu->setActive(URL::full());

        return view('components.layout.galaxyhub.header', [
            'menu' => $menu
        ]);
    }
}
