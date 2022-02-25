<x-theme.galaxyhub.sub-content :title="$title" :description="$title" :breadcrumbs="Diglactic\Breadcrumbs\Breadcrumbs::render('app.admin.application', $user->name)">
    <x-panel.galaxyhub.basics>
        <div x-data="application_games">
            <h2 class="text-xl lg:text-2xl font-bold mb-4">게임 목록 <span class="text-sm font-normal" x-text="data.game_count + '개'"></span></h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="game in data.games">
                    <div class="rounded border border-gray-300 dark:border-gray-800 shadow-sm">
                        <img class="w-full rounded-t" :src="'http://media.steampowered.com/steamcommunity/public/images/apps/' + game.appid + '/' + game.img_logo_url + '.jpg'" :alt="game.name">
                        <div class="px-6 py-4">
                            <p class="font-bold text mb-2 line-clamp-2 h-12" x-text="game.name"></p>
                            <p class="text-gray-700 dark:text-gray-300 text-base" x-text="minutesToHm(game.playtime_forever)"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <script type="text/javascript">
            window.document.addEventListener('alpine:init', () => {
                window.alpine.data('application_games', () => ({
                    data: {!! $games !!},
                    sortByPlayTime() {
                        let games = [];

                        if (this.data.games !== null) {
                            let k = Object.keys(this.data.games).sort((a,b)=> this.data.games[a].playtime_forever - this.data.games[b].playtime_forever).reverse();

                            for (let i in k) {
                                games.push(this.data.games[k[i]])
                            }

                            this.data.games = games;
                        }
                    },
                    init(){
                        this.sortByPlayTime();
                    },
                    minutesToHm(minutes) {
                        let h = Math.floor(minutes / 60);
                        let m = Math.floor(minutes % 60);

                        let hd = h > 0 ? h + '시간' : '';
                        let md = m > 0 ? m + '분' : '';

                        return (hd === '' && md === '') ? '0분' : hd + ' ' + md;
                    }
                }));
            });
        </script>
    </x-panel.galaxyhub.basics>
</x-theme.galaxyhub.sub-content>
