@foreach ($tutores as $tutor)
    <div class="flex justify-between items-center bg-purple-300 rounded-2xl p-4">
        <div>
            <h1 href="{{ route("tutores.show",$tutor->id_tutor) }}">{{ $tutor->nm_tutor }}</h1>
            <p>{{ $tutor->nm_email_tutor }}</p>
            <p>{{ $tutor->nm_endereco_tutor }}</p>
            <p>{{ $tutor->cd_telefone_tutor }}</p>
            <p>{{ $tutor->cd_cpf_tutor }}</p>
            
            @if ($tutor->pet->isNotEmpty())
                <div class="h-9"></div>
                @foreach ($tutor->pet as $pet)
                    <p>{{ $pet->nm_pet }}</p>
                @endforeach
            @endif


        </div>

        <div class="flex gap-1">
            <a href="{{ route('tutores.pets.create',$tutor) }}">Adicionar Pet</a>
            <a href="{{ route('tutores.pets.index',$tutor) }}">Listar Pets</a>

            <a href="{{ route('tutores.edit',$tutor->id_tutor) }}">Editar</a>
            <form method="post" action="{{ route('tutores.destroy',$tutor->id_tutor) }}">
                @csrf
                @method("DELETE")
                <button type="submit">Remover</button>
            </form>
        </div>
    </div>
    <br>
@endforeach