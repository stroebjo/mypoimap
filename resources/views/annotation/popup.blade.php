<div class="m-popup">
    <h4 class="h5 m-popup-title">
        <a href="{{ route('annotation.show', [$annotation]) }}" class="invisible-link">{{ $annotation->name }}</a>
    </h4>

    <div class="m-popup-description">
        @parsedown($annotation->description)
    </div>
</div>
