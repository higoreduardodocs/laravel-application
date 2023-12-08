@extends('layouts.main')
@section('title', 'Início')

@section('content')

<div id="search-container" class="col-md-12">
  <h1>Busque um evento</h1>
  <form action="/" method="GET">
    <input type=" text" id="search" name="search" class="form-control" placeholder="Procurar...">
  </form>
</div>
<div id="events-container" class="col-md-12">
  @if($search)
  <h2>Eventos da busca: {{ $search }}</h2>
  @else
  <h2>Próximos Eventos</h2>
  @endif
  <p class="subtitle">Veja os eventos dos próximos dias</p>
  @if(count($events) == 0 && $search)
  <p>Não foi possível encontrar nenhum evento com {{ $search }}! <a href="/">Ver todos</a></p>
  @elseif(count($events) == 0)
  <p>Não há eventos disponíveis</p>
  @else
  <div id="cards-container" class="row">
    @foreach($events as $event)
    <div class="card col-md-3">
      <img src="img/events/{{ $event->image }}" alt="{{ $event->title }}" />
      <div class="card-body">
        <p class="card-date">{{ date('d/m/Y', strtotime($event->date)) }}</p>
        <h5 class="card-title">{{ $event->title }}</h5>
        <p class="cad-participants">{{ count($event->users) }} Participantes</p>
        <a href="/eventos/{{ $event->id }}" class="btn btn-primary">Saber mais</a>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>

@endsection