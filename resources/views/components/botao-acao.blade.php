@props(['action', 'icone', 'titulo', 'metodo' => 'POST', 'confirmar' => null, 'perigo' => false])
<form method="POST" action="{{ $action }}" @if ($confirmar) data-confirmar="{{ $confirmar }}" @endif>
  @csrf
  @if (strtoupper($metodo) !== 'POST') @method($metodo) @endif
  <button class="btn-icone {{ $perigo ? 'perigo' : '' }}" type="submit" title="{{ $titulo }}" aria-label="{{ $titulo }}"><x-icone :nome="$icone" /></button>
</form>