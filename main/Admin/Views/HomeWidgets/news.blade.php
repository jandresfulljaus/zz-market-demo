@if ($news->isNotEmpty())
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">&Uacute;ltimas noticias</h6>

                <div class="header-elements">
                    <a href="{{ Config('fulljaus.url_web') }}/noticias">Ver m&aacute;s</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row p-0">
                    @foreach($news as $post)
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <ul class="media-list m-3">
                                <li class="media">
                                    <div class="mr-3">
                                        <a href="{{ Config('fulljaus.url_web').$post->url($post->id, $post->title) }}">
                                            @php
                                                $base_url = Config('fulljaus.url_web');
                                                $base_url = str_replace('https:', '', $base_url);
                                                $image_url = $post->thumbnails->icon ?? $post->file()->first()->name ?? '';
                                                $image_url = str_replace('https:', '', $image_url);

                                                $url = (strpos($image_url, $base_url) !== false)?$image_url:$base_url.$image_url;
                                            @endphp
                                            <img width="100" src="{{ $url }}" alt="{{ $post->file()->first()->name ?? '' }}">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-0">
                                            <a href="{{ Config('fulljaus.url_web').$post->url($post->id, $post->title) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h6>
                                        <span class="text-muted font-size-sm">{{ date('d/m/Y', strtotime($post->published)) }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
