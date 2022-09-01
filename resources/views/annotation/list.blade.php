@php
    $type = 'place_id';

    if (get_class($annotatable) == 'App\\Journey') {
        $type = 'journey_id';
    }
@endphp
<section>
    <header class="m-contentheader d-sm-flex justify-content-between">
        <h5 class="">{{ __('Annotations') }}</h1>

        <div class="mb-1">
            @auth
                <a class="btn btn-sm btn-outline-primary" href="{{ route('annotation.link', [$type => $annotatable->id]) }}">{{ __('Link')}}</a>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('annotation.create', [$type => $annotatable->id]) }}">{{ __('Create')}}</a>
            @endauth
        </div>
    </header>

    <div>
        @if(count($annotations))
        <table class="w-100 table table-sm table-hover">

            <tbody>
            @foreach($annotations as $annotation)
                <tr>
                    <td>
                        <a href="{{ route('annotation.show', [$annotation]) }}">{{ $annotation->name }}</a>
                    </td>
                    @auth
                    <td>
                        <div class="d-flex justify-content-end">
                            <form method="POST" action="{{ route('annotation.destroyLink') }}" onsubmit="return confirm('{{ __('This will remove the link to the annotation. The annotation will not be deleted.') }}')">
                                @csrf
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="annotation_id" value="{{ $annotation->id }}">
                                <input type="hidden" name="annotatable_type" value="{{ get_class($annotatable) }}">
                                <input type="hidden" name="annotatable_id" value="{{ $annotatable->id }}">
                                <button type="submit" class="btn btn-xs btn-link ms-2"><span class="text-danger">@svg('x')</span></button>
                            </form>
                        {{--
                        <a href="{{ route('annotation.edit', [$annotation]) }}">{{ __('Edit') }}</a>
                        --}}
                        </div>
                    </td>
                    @endauth
            @endforeach
            </tbody>
        </table>
        @else
            <small class="text-muted">{{ __('No annotations linked yet.')}}</small>
        @endif
    </div>
</section>
