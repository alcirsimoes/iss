@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $survey->name }} - {{ $sample->name }}</div>

                <div class="panel-body">
                    @forelse($questions as $question)

                    <div class="panel panel-default">
                        <div class="panel-heading">{!! $question->statement !!}</div>

                        <div class="panel-body">
                            @if($question->type == 1)
                            <table class="table table-striped">
                                <thead>
                                    <th>Opção {!! $question->options_header !!} {!! $question->answers_header !!}</th>
                                    <th>Contagem</th>
                                    <th>Porcentagem</th>
                                </thead>

                                <tbody>
                                    @forelse($question->options as $option)
                                    <tr>
                                        <td>{{ $option->statement }}</td>
                                        @if(isset($processamento[$question->id]['respostas'][$option->statement]))
                                        <td>{{ $processamento[$question->id]['respostas'][$option->statement] }}</td>
                                        @else<td></td>
                                        @endif
                                        @if(isset($processamento[$question->id]['porcentagens'][$option->statement]))
                                        <td>{{ $processamento[$question->id]['porcentagens'][$option->statement] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    @empty
                                        @forelse($question->father->first()->options as $option)
                                        <tr>
                                            <td>{{ $option->statement }}</td>
                                            @if(isset($processamento[$question->id]['respostas'][$option->statement]))
                                            <td>{{ $processamento[$question->id]['respostas'][$option->statement] }}</td>
                                            @else<td></td>
                                            @endif
                                            @if(isset($processamento[$question->id]['porcentagens'][$option->statement]))
                                            <td>{{ $processamento[$question->id]['porcentagens'][$option->statement] }}</td>
                                            @else<td></td>
                                            @endif
                                        </tr>
                                        @empty
                                        @endforelse
                                    @endforelse
                                    <tr>
                                        <td>Recusou</td>
                                        <td>{{ $processamento[$question->id]['respostas']['Recusou'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Recusou']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Recusou'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Não sabe</td>
                                        <td>{{ $processamento[$question->id]['respostas']['Não Sabe'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Não Sabe']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Não Sabe'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>{{ $processamento[$question->id]['respostas']['Total'] }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>

                            </table>
                            @endif

                            @if($question->type == 2)
                            <table class="table table-striped">
                                <thead>
                                    <th>Opção {!! $question->options_header !!} {!! $question->answers_header !!}</th>
                                    <th>Contagem</th>
                                    <th>Porcentagem</th>
                                </thead>

                                <tbody>
                                    @forelse($question->options as $option)
                                    <tr>
                                        <td>{{ $option->statement }}</td>
                                        @if(isset($processamento[$question->id]['respostas'][$option->statement]))
                                        <td>{{ $processamento[$question->id]['respostas'][$option->statement] }}</td>
                                        @else<td></td>
                                        @endif
                                        @if(isset($processamento[$question->id]['porcentagens'][$option->statement]))
                                        <td>{{ $processamento[$question->id]['porcentagens'][$option->statement] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    @empty
                                        @forelse($question->father->first()->options as $option)
                                        <tr>
                                            <td>{{ $option->statement }}</td>
                                            @if(isset($processamento[$question->id]['respostas'][$option->statement]))
                                            <td>{{ $processamento[$question->id]['respostas'][$option->statement] }}</td>
                                            @else<td></td>
                                            @endif
                                            @if(isset($processamento[$question->id]['porcentagens'][$option->statement]))
                                            <td>{{ $processamento[$question->id]['porcentagens'][$option->statement] }}</td>
                                            @else<td></td>
                                            @endif
                                        </tr>
                                        @empty
                                        @endforelse
                                    @endforelse
                                    <tr>
                                        <td>Recusou</td>
                                        <td>{{ $processamento[$question->id]['respostas']['Recusou'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Recusou']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Recusou'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Não sabe</td>
                                        <td>{{ $processamento[$question->id]['respostas']['Não Sabe'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Não Sabe']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Não Sabe'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>{{ $processamento[$question->id]['respostas']['Total'] }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>

                            </table>
                            @endif

                            @if($question->type == 3)
                            <table class="table table-striped">
                                <thead>
                                    <th>Opção {!! $question->options_header !!} {!! $question->answers_header !!}</th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @forelse($question->options as $option)
                                    @if(isset($processamento[$question->id][$option->statement]))
                                        @forelse($processamento[$question->id][$option->statement] as $resposta)
                                        <tr>
                                            <td>{{ $option->statement }}</td>
                                            <td>{{ $resposta }}</td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    @endif
                                    @empty
                                        @forelse($processamento[$question->id] as $resposta)
                                        <tr>
                                            <td>{{ $resposta }}</td>
                                            <td></td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    @endforelse
                                    <tr>
                                        <td>Recusou</td>
                                        <td>{{ $processamento[$question->id]['Recusou'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Não sabe</td>
                                        <td>{{ $processamento[$question->id]['Não Sabe'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>{{ $processamento[$question->id]['Total'] }}</td>
                                    </tr>
                                </tbody>

                            </table>
                            @endif

                            @if($question->type == 4)
                            <table class="table table-striped">
                                <thead>
                                    <th>Opção {!! $question->options_header !!} {!! $question->answers_header !!}</th>
                                    <th>Média</th>
                                    <th>Contagem</th>
                                </thead>

                                <tbody>
                                    @forelse($question->options as $option)
                                    <tr>
                                        <td>{{ $option->statement }}</td>
                                        @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                        <td>{{ $processamento[$question->id][$option->statement]['media'] }}</td>
                                        @else<td></td>
                                        @endif
                                        @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                        <td>{{ $processamento[$question->id][$option->statement]['contagem'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    @empty
                                        @forelse($question->father->first()->options as $option)
                                        <tr>
                                            <td>{{ $option->statement }}</td>
                                            @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                            <td>{{ $processamento[$question->id][$option->statement]['media'] }}</td>
                                            @else<td></td>
                                            @endif
                                            @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                            <td>{{ $processamento[$question->id][$option->statement]['contagem'] }}</td>
                                            @else<td></td>
                                            @endif
                                        </tr>
                                        @empty
                                        @endforelse
                                    @endforelse
                                    <tr>
                                        <td>Recusou</td>
                                        <td>{{ $processamento[$question->id]['Recusou'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Recusou']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Recusou'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Não sabe</td>
                                        <td>{{ $processamento[$question->id]['Não Sabe'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Não Sabe']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Não Sabe'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>{{ $processamento[$question->id]['Total'] }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>

                            </table>
                            @endif

                            @if($question->type == 5)
                            <table class="table table-striped">
                                <thead>
                                    <th>Opção {!! $question->options_header !!} {!! $question->answers_header !!}</th>
                                    @if($question->father->first() && count($question->options))
                                    @foreach ($question->options as $header)
                                    <th>{{ $header->statement }} Média</th>
                                    <th>{{ $header->statement }} Contagem</th>
                                    @endforeach
                                    @else
                                    <th>Média</th>
                                    <th>Contagem</th>
                                    @endif
                                </thead>

                                <tbody>
                                    @if($question->father->first() && count($question->options))
                                    @forelse($question->father->first()->options as $option)
                                    <tr>
                                        <td>{{ $option->statement }}</td>
                                        @foreach($question->options as $suboption)
                                        @if(isset($processamento[$question->id][$option->statement][$suboption->statement]['contagem']))
                                        <td>{{ $processamento[$question->id][$option->statement][$suboption->statement]['media'] }}</td>
                                        @else <td></td>
                                        @endif
                                        @if(isset($processamento[$question->id][$option->statement][$suboption->statement]['contagem']))
                                        <td>{{ $processamento[$question->id][$option->statement][$suboption->statement]['contagem'] }}</td>
                                        @else <td></td>
                                        @endif
                                        @endforeach
                                    </tr>
                                    @empty
                                    @endforelse
                                    @else

                                        @forelse($question->options as $option)
                                        <tr>
                                            <td>{{ $option->statement }}</td>
                                            @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                            <td>{{ $processamento[$question->id][$option->statement]['media'] }}</td>
                                            @else<td></td>
                                            @endif
                                            @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                            <td>{{ $processamento[$question->id][$option->statement]['contagem'] }}</td>
                                            @else<td></td>
                                            @endif
                                        </tr>
                                        @empty
                                            @forelse($question->father->first()->options as $option)
                                            <tr>
                                                <td>{{ $option->statement }}</td>
                                                @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                                <td>{{ $processamento[$question->id][$option->statement]['media'] }}</td>
                                                @else<td></td>
                                                @endif
                                                @if(isset($processamento[$question->id][$option->statement]['contagem']))
                                                <td>{{ $processamento[$question->id][$option->statement]['contagem'] }}</td>
                                                @else<td></td>
                                                @endif
                                            </tr>
                                            @empty
                                            @endforelse
                                        @endforelse
                                    @endif
                                    
                                    <tr>
                                        <td>Recusou</td>
                                        <td>{{ $processamento[$question->id]['Recusou'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Recusou']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Recusou'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Não sabe</td>
                                        <td>{{ $processamento[$question->id]['Não Sabe'] }}</td>
                                        @if(isset($processamento[$question->id]['porcentagens']['Não Sabe']))
                                        <td>{{ $processamento[$question->id]['porcentagens']['Não Sabe'] }}</td>
                                        @else<td></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td>{{ $processamento[$question->id]['Total'] }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>

                            </table>
                            @endif

                        </div>
                    </div>
                    @empty
                    <h3>Questionário sem nenhuma resposta.</h3>
                    @endforelse
                </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
