<label class="block">
    <p class="leading-6 font-medium text-gray-900 dark:text-gray-100 mb-0.5">{!! $question->title !!} {!! in_array('required', $question->rules) ? '<span class="text-red-600 text-base">*</span>' : '' !!}</p>
    @if (is_null($answer))
        <p class="text-sm text-gray-500 dark:text-gray-300 mb-2">{!! $question->content !!}</p>
        <div id="{{ $question->key }}_files"></div>
        <input type="file" name="filepond" id="{{ $question->key }}" multiple data-max-file-size="10MB" data-max-files="10" {{ in_array('required', $question->rules) ? 'required' : '' }} />
        @error($question->key)
            <p class="text-sm text-red-700 mt-1">{{ $message }}</p>
        @enderror
        @if (!$errors->isEmpty())
            <p class="text-sm text-red-700 mt-1">만약 첨부한 파일이 있다면 다시 업로드하여 주십시오.</p>
        @endif
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-2" x-data="{{ $componentId }}">
            <template x-for="file in data.images.data.files">
                <div class="relative p-1 rounded border border-gray-300 dark:border-gray-800">
                    <a class="absolute rounded inset-0 z-10 bg-white dark:bg-gray-900 text-center text-xs flex flex-col items-center justify-center opacity-0 hover:opacity-100 bg-opacity-90 duration-300" :href="file.path" target="_blank" rel="noopener">
                        <p class="h-12" x-text="file.name"></p>
                        <p class="mx-auto underline hover:no-underline">새 창으로 보기</p>
                    </a>
                    <a :href="file.path" target="_blank" class="relative" rel="noopener">
                        <div class="flex flex-wrap content-center">
                            <img :src="file.path" class="mx-auto" :alt="file.name"/>
                        </div>
                    </a>
                </div>
            </template>

            {{--
            @if(count($answer) > 0)
                @foreach($answer as $v)
                    <div class="relative">
                        <a class="absolute inset-0 z-10 bg-white text-center flex flex-col items-center justify-center opacity-0 hover:opacity-100 bg-opacity-90 duration-300" href="{{ $v['path'] }}" target="_blank">
                            <p class="tracking-wider">{{ $v['name'] }}</p>
                            <p class="mx-auto underline hover:no-underline">새 창으로 보기</p>
                        </a>
                        <a href="{{ $v['path'] }}" target="_blank" class="relative">
                            <div class="flex flex-wrap content-center">
                                <img src="{{ $v['path'] }}" class="mx-auto" alt="{{ $v['name'] }}">
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p class="text-sm -mt-2">첨부된 파일 없음</p>
            @endif
            --}}
        </div>
    @endif
</label>

<script type="text/javascript">
@if(is_null($answer))
let filepond_js = [
    'https://cdn.jsdelivr.net/npm/filepond@4.30.3/dist/filepond.min.js',
    'https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-type@1.2.6/dist/filepond-plugin-file-validate-type.min.js',
    'https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-size@2.2.5/dist/filepond-plugin-file-validate-size.min.js',
]

let filepond_css = [
    'https://cdn.jsdelivr.net/npm/filepond@4.30.3/dist/filepond.min.css',
]

if (!Boolean(document.querySelector('script[src="' + filepond_js[0] + '"]'))) {
    filepond_js.forEach(i => {
        let script = document.createElement('script');
        script.src = i;

        document.head.appendChild(script);
    });
}

if (!Boolean(document.querySelector('link[href="' + filepond_css[0] + '"]'))) {
    filepond_css.forEach(i => {
        let link = document.createElement('link');
        link.href = i;
        link.rel = 'stylesheet';

        document.head.appendChild(link);
    });
}

window.addEventListener('load', () => {
    FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
    let files = [];
    let pond = FilePond.create(document.querySelector('#{{$question->key}}'));
    pond.setOptions({
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                let cancelToken = axios.CancelToken;
                let source = cancelToken.source();

                let axios_success = (r) => {
                    load(r.data.data.id);
                    files.push(r.data.data.id);
                };
                let axios_error = (e) => {
                    if (typeof e.response !== 'undefined') {
                        if (e.response.status === 415) {
                            //CSRF 토큰 오류 발생
                            error('로그인 정보를 확인할 수 없습니다.');
                            abort();
                            return;
                        }

                        if (e.response.status === 422) {
                            let msg = '';
                            switch (e.response.data.description) {
                                default:
                                    msg = e.response.data.description;
                                    break;
                            }

                            error(msg);
                            abort();
                            return;
                        }
                    }
                    error('데이터 처리 중 문제가 발생하였습니다.');
                    abort();

                    console.log(e);
                };
                let axios_complete = () => {};
                let axios_config = {
                    cancelToken: source.token,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    }
                };
                let axios_body = new FormData();
                axios_body.append(fieldName, file, file.name);

                window.axios.post('{{ route('file.upload.filepond', 'survey') }}', axios_body, axios_config).then(axios_success).catch(axios_error).then(axios_complete);

                return {
                    abort: () => {
                        source.cancel();
                        abort();
                    }
                };
            },
            revert: (id, load, error) => {
                let axios_success = (r) => {
                    load();
                    files = files.filter((e) => e !== Number(id));
                };
                let axios_error = (e) => {
                    if (typeof e.response !== 'undefined') {
                        if (e.response.status === 415) {
                            //CSRF 토큰 오류 발생
                            error('로그인 정보를 확인할 수 없습니다.');
                            return;
                        }

                        if (e.response.status === 422) {
                            let msg = '';
                            switch (e.response.data.description) {
                                default:
                                    msg = e.response.data.description;
                                    break;
                            }

                            error(msg);
                            return;
                        }
                    }

                    error('데이터 처리 중 문제가 발생하였습니다.');
                    console.log(e);
                };
                let axios_complete = () => {

                };
                let axios_body = {
                    id: id
                };

                window.axios.post('{{ route('file.delete.filepond', 'survey') }}', axios_body).then(axios_success).catch(axios_error).then(axios_complete);
            }
        },
        required: {{ in_array('required', $question->rules) ? 'true' : 'false' }},
        acceptedFileTypes: ['image/*']
    });

    let {{ $question->key }} = () => {
        let field = document.querySelector('#{{$question->key}}_files');
        field.innerHTML = '';
        files.forEach((v, i) => {
            let input = document.createElement('input');
            input.name = '{{$question->key}}[]';
            input.type = 'hidden';
            input.value = v;

            field.appendChild(input);
        })
    };

    pond.on('processfile', (e) => {
        {{ $question->key }}();
    });
    pond.on('removefile', (e) => {
        {{ $question->key }}();
    });
});
@else
window.addEventListener('alpine:init', () => {
    window.alpine.data('{{ $componentId }}', () => ({
        component_id: '{{ $componentId }}',
        load: {
            images: false,
        },
        data: {
            images: {
                url: '{{ route('file.get.filepond') }}',
                body: {
                    id: {!! json_encode($answer) !!},
                },
                data: {
                    files: []
                },
            }
        },
        init() {
            this.images();
        },
        images() {
            let success = (r) => {
                if (r.data.data !== null) {
                    if (!(typeof r.data.data === 'undefined' || r.data.data.length <= 0)) {
                        this.data.images.data = r.data.data;
                    }
                }
            };

            let error = (e) => {
                if (typeof e.response !== 'undefined' && e.response.status === 415) {
                    //CSRF 토큰 오류 발생
                    window.modal.alert('처리 실패', '로그인 정보를 확인할 수 없습니다.', (c) => {
                        Location.reload();
                    }, 'error');
                    return;
                }

                window.modal.alert('오류', '이미지를 불러오는 중 문제가 발생하였습니다.', (c) => {}, 'error');
                console.log(e);
            };

            let complete = () => {
                this.load.images = false;
            };

            this.post(this.data.images.url, this.data.images.body, success, error, complete);
        },
        post(url, body, success, error, complete) {
            window.axios.post(url, body).then(success).catch(error).then(complete);
        }
    }));
});
@endif
</script>
