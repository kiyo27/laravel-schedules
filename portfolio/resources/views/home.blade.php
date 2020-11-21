@extends('layouts.app')

@section('content')
<example-component></example-component>
@endsection

<script>
    window.apiToken = "{{ $token  }}"
    console.log(apiToken);
</script>
