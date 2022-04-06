<div class="ticket-container">
    <div class="ticket-upper-section">
        <div class="ticket-content-block">
            <p class="ticket-number">{{ $datos['id'] }}</p>
            <span class="ticket-tag ticket-tag-{{ $datos['highlightcolor'] ?? 'warning' }}">{{ $datos['highlight'] }}</span>
        </div>
        <div class="ticket-content-block">
            <p class="ticket-problem-title">{{ $datos['title'] }}</p>
            <p class="ticket-problem-description">{{ $datos['description'] }}</p>
        </div>
    </div>
    <div class="ticket-lower-section">
        @if (! empty($datos["bottomrecord"]))
            @foreach ($datos["bottomrecord"] as $bottomkey => $rBottomData)
                <div class="ticket-content-block">
                    <p class="ticket-info-title">{{ $bottomkey }}</p>
                    <p class="ticket-info-description">{!! $rBottomData !!}</p>
                </div>
            @endforeach
        @endif
        @if (! empty($aActions))
            <div class="ticket-content-block">
                <p class="ticket-info-title">Acciones</p>
                <p class="ticket-info-description">
                    @foreach ($datos['actions'] as $i => $rAction)
                        <a href="{{ $rAction['action'] }}{{ $rData['id'] }}" class="btn btn-sm {{ $rAction['color'] }}">
                            <i class="material-icons">{{ $rAction['icon'] }}</i>
                        </a>
                    @endforeach
                </p>
            </div>
        @endif
        @if (! empty($datos['hiddenTable']))
            <div class="ticket-content-block">
                <p class="ticket-info-title">{{ $datos['hiddenTable']['button']['text'] }}</p>
                <p class="ticket-info-description">
                    <button class="btn btn-sm {{ $datos['hiddenTable']['button']['class'] }}" type="button" data-toggle="collapse" data-target="#hiddenTable{{ $datos['id'] }}" aria-expanded="false" aria-controls="hiddenTable{{ $datos['id'] }}">
                        <i class="{{ $datos['hiddenTable']['button']['icon'] }}"></i>
                    </button>
                </p>
            </div>
        @endif
    </div>
    @if (! empty($datos['hiddenTable']))
        <div id="hiddenTable{{ $datos['id'] }}" class="collapse" style="border-top: 2px solid var(--lower-border-color); padding: 10px 20px;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        @foreach ($datos['hiddenTable']['titles'] as $htkey => $title)
                            <th>{{ $title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos['hiddenTable']['records'] as $htkey => $htRecord)
                        <tr>
                            @foreach ($htRecord as $htrkey => $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
