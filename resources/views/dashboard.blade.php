@extends('layouts.app')

@section('content')

@push('scripts')

<script>
    let showUrl = new Vue({
        el: '#dashboard',
        data: {
            link_count: '{{ $urls->count() }}',
            total_hits_count: '{{ $total_hits_count }}',
            total_leads_count: '{{ $total_leads_count }}',
        },
        methods: {

        },
        updated: function() {

        },
        mounted: function() {

        }
    })
</script>

@endpush

<div id="dashboard" class="container" v-cloak>
    <div class="card">
        <div class="card-header">
            Dashboard
        </div>
        <div class="card-body">
            <div class="d-flex flex-row justify-content-around">
                <div class="url_count p-2">
                    <p id="link_count" class="url_count_number text-monospace text-center"> @{{ link_count }} </p>
                    <p class="url_count_link text-monospace text-center">Links</p>
                </div>
                <div class="url_count p-2">
                    <p id="link_count" class="url_count_number text-monospace text-center"> @{{ total_leads_count }} </p>
                    <p class="url_count_link text-monospace text-center">Total Leads Captured</p>
                </div>
                <div class="url_count p-2">
                    <p id="total_hit_count" class="url_count_number text-monospace text-center"> @{{ total_hits_count }} </p>
                    <p class="url_count_link text-monospace text-center">Total Hits Count</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
