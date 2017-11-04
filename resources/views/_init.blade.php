<script>
window.__CONFIG__ = {
    app: {!! collect(config('app'))->only(['name'])->put('url', url('/')) !!}
};
</script>
