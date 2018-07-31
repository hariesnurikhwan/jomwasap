@extends('layouts.app')

@section('content')

@push('scripts')

<script>
    let showUrl = new Vue({
        el: '#showUrl',
        data: {
            leads: [],
        },
        methods: {
            deleteLead: function(id, index) {
                axios.post('/api/lead/' + id).then((res) => {
                    this.leads.splice(index, 1);
                });
            }
        },
        updated: function() {

        },
        mounted: function() {
            @foreach($url->lead as $lead)
            this.leads.push({
                name: '{{ $lead->name }}',
                mobile_number: '{{ $lead->mobile_number }}',
                id: '{{ $lead->id }}'
            })
            @endforeach
        }
    })
</script>

@endpush

<div id="showUrl" class="container" v-cloak>
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    View "{{ $url->alias }}" Link Content.
                    <a href="{{ route('generate.edit', $url->hashid) }}" class="btn btn-success btn-sm float-right">Edit Link</a>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-3">URL</dt>
                        <dd class="col-9">
                            <a href="https://hi.jomwasap.my/{{ $url->alias }}">https://hi.jomwasap.my/{{ $url->alias }}</a>
                            <div class="pull-right">
                                <button class="btn btn-info btn-sm" data-clipboard-text="{{ url('https://hi.jomwasap.my/' . $url->alias) }}">
                                    <span class="fa fa-copy"></span>
                                </button>
                            </div>
                        </dd>
                        @if ($url->type === 'single')
                        <dt class="col-3">Mobile Number</dt>
                        <dd class="col-9"> {{ phone($url->mobile_number, 'MY') }} </dd>
                        @else
                        <dt class="col-3">Mobile Numbers</dt>
                        @foreach($url->group->pluck('mobile_number') as $number)
                        <dd class="col-9">{{ phone($number, 'MY') }}</dd>
                        @endforeach
                        @endif
                        <dt class="col-3">Lead Capture</dt>
                        <dd class="col-9">{{$url->enable_lead_capture ? "Enabled" : "Disabled"}}</dd>
                        @if ($url->text)
                        <dt class="col-3">Pretext Chat</dt>
                        <dd class="col-9"><pre>{{ $url->text }}</pre></dd>
                        @endif
                    </dl>
                    <hr>
                    <h6>Leads Captured</h6>
                    <table class="table table-borderless table-hover">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile Number</th>
                            <th>Action</th>
                        </tr>

                        <tr v-for="(lead, index) in leads">
                            <td>@{{index + 1}}</td>
                            <td>@{{lead.name}}</td>
                            <td>@{{lead.mobile_number}}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger" v-on:click.prevent="deleteLead(lead.id, index)">Delete</button>
                            </td>
                        </tr>

                        {{-- @foreach($url->lead as $lead)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$lead->name}}</td>
                            <td>{{$lead->mobile_number}}</td>
                            <td>
                                <a class="btn btn-sm btn-outline-danger" href="#">Delete</a>
                            </td>
                        </tr>
                        @endforeach --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
