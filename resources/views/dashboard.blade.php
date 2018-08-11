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
            var ctx = document.getElementById('state').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                    datasets: [{
                        label: ' of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
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
            <div class="d-flex flex-row justify-content-start">
                <div class="p-2">
                    <canvas id="state"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
