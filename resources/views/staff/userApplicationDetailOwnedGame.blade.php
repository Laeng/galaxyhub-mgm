<x-sub-page website-name="MGM Lounge" title="{{ $title }}">
    <x-section.basic parent-class="py-4 sm:py-6 lg:py-16" class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg p-4 lg:p-16">
                <h1 class="text-2xl lg:text-3xl font-bold text-center lg:text-left my-4 lg:mt-0 lg:mb-6">{{$title}}</h1>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="application_detail_games">
                    <template x-for="game in data.games">
                        <div class="rounded border border-gray-200 shadow-sm">
                            <img class="w-full rounded-t" :src="game.logo" :alt="game.name">
                            <div class="px-6 py-4">
                                <p class="font-bold text mb-2 line-clamp-2 h-12" x-text="game.name"></p>
                                <p class="text-gray-700 text-base" x-text="Math.floor(game.playtimeForever/60) + '시간'">

                                </p>
                            </div>
                        </div>
                    </template>
                </div>
                <script type="text/javascript">
                    function application_detail_games() {
                        return {
                            data: {
                                games: {!! $games !!}
                            },
                            sortByPlayTime() {
                                let games = [];
                                let k = Object.keys(this.data.games).sort((a,b)=> this.data.games[a].playtimeForever - this.data.games[b].playtimeForever).reverse();

                                for (let i in k) {
                                    games.push(this.data.games[k[i]])
                                }

                                this.data.games = games;
                            },
                            init(){
                                this.sortByPlayTime();
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </x-section.basic>
</x-sub-page>
