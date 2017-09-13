<?php

use App\Survey;
use App\Option;
use App\Question;
use App\Condition;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SurveysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $survey = Survey::create([
            'name' => 'Krones Satisfação e Imagem Processos',
            'type' => 2,
            'intro' => 'Bom dia/Boa tarde, meu nome é ___________, trabalho na H2M, empresa que desenvolve estudos de mercado. O motivo de nosso contato é porque estamos <strong>realizando um estudo sobre fornecedores de máquinas, equipamentos e soluções para o mercado de PROCESSOS DE FABRICAÇÃO DE BEBIDAS.</strong> É importante que você saiba que suas informações são sigilosas e suas informações serão analisadas em conjunto com as informações dos demais entrevistados. Desde já agradecemos a sua participação.',
            'init_at' => Carbon::now()->addDays(1),
            'end_at' => Carbon::now()->addDays(30),
            'active' => true,
        ]);

        $question_1 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'R1',
            'statement' => '<strong>R1)</strong> Tipo: <strong>(ANOTAR DA LISTAGEM)(RU)</strong>',
            'type' => 1,
            'format' => 2,
            'order' => 0,
        ]);
        $options_1 = [
            Option::create([
                'statement' => 'Cliente',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Potencial',
                'value' => 2,
            ])
        ];
        $question_1->options()->saveMany($options_1);


        $question_2 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'R3',
            'statement' => '<strong>R3)</strong> Área: <strong>(PERGUNTAR) (RM)</strong>',
            'type' => 2,
            'format' => 2,
            'order' => 1,
            'other' => 1,
        ]);

        $options_2 = [
            Option::create([
                'statement' => 'Técnica',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Comercial',
                'value' => 2,
            ])
        ];
        $question_2->options()->saveMany($options_2);

        $collumns = [];
        $question_3 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P1',
            'options_header' => 'FORNECEDORES <strong>(PROCESSOS DE FABRICAÇÃO DE BEBIDAS)</strong>',
            'answers_header' => 'P1 <strong>(RU)</strong> 1ª Menção',
            'statement' => '<strong>P1)</strong> Inicialmente gostaríamos de saber quais <strong>fornecedores de máquinas, equipamentos e soluções para o mercado de PROCESSOS DE FABRICAÇÃO DE BEBIDAS</strong> você conhece, mesmo que só de ouvir falar? <strong>(NÃO LEIA O NOME DAS EMPRESAS - ANOTE A 1ª MENÇÃO EM SEPARADO)</strong>',
            'type' => 1,
            'format' => 3,
            'order' => 2,
            'other' => true,
            'none' => true,
            'unknow' => true,
        ]);

        $options_3 = [
            Option::create([
                'statement' => 'Krones',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Gea',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Liess',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'KHS',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Miteco',
                'value' => 5,
            ]),
            Option::create([
                'statement' => 'Tetrapak',
                'value' => 6,
            ]),
            Option::create([
                'statement' => 'Pentair',
                'value' => 7,
            ]),
            Option::create([
                'statement' => 'Alpha Laval',
                'value' => 8,
            ]),
            Option::create([
                'statement' => 'SPX',
                'value' => 9,
            ]),
            Option::create([
                'statement' => 'Nenhum',
                'value' => 10,
            ]),
            Option::create([
                'statement' => 'Não sabe',
                'value' => 11,
            ]),
        ];
        $question_3->options()->saveMany($options_3);

        $collumns [] = $question_4 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P1a',
            'answers_header' => 'P1a <strong>(RM)</strong> Espontâneo',
            'statement' => null,
            'type' => 2,
            'format' => null,
            'other' => true,
            'none' => true,
            'unknow' => true,
        ]);

        $collumns [] = $question_5 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P2',
            'answers_header' => 'P2 <strong>(RM)</strong> Estimulado',
            'statement' => '<strong>P2)</strong> Além das que você mencionou quais outros fornecedores destes que eu vou mencionar você conhece? <strong><span class="text-danger">(PARA O SEGMENTO PROCESSOS DE FABRICAÇÃO:</span> MENCIONAR SOMENTE GEA, LIESS, MITECO, TETRAPAK, KHS CASO NÃO MENCIONAOU NA P1 E P1A) – (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 2,
            'format' => null,
            'other' => true,
            'none' => true,
            'unknow' => true,
        ]);

        $collumns [] = $question_6 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P3',
            'answers_header' => 'P3 <strong>(RM)</strong> Trabalha',
            'statement' => '<strong>P3)</strong> Com quais destes <strong>fornecedores</strong> a sua empresa <strong>trabalha</strong> hoje?',
            'type' => 2,
            'format' => null,
            'other' => true,
            'none' => true,
            'unknow' => true,
        ]);

        $collumns [] = $question_7 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P3a',
            'answers_header' => 'P3a <strong>(RM)</strong> Deixou de trabalhar',
            'statement' => '<strong>P3a)</strong> Com qual destes <strong>fornecedores</strong> sua empresa <strong>trabalhava e deixou de trabalhar?</strong>',
            'type' => 2,
            'format' => null,
            'other' => true,
            'none' => true,
            'unknow' => true,
        ]);

        $collumns [] = $question_8 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P4',
            'answers_header' => 'P4 <strong>(RU)</strong> Melhor',
            'statement' => '<strong>P4)</strong> Qual desses <strong>fornecedores</strong> você considera como o <strong>melhor</strong> do mercado?',
            'type' => 1,
            'format' => null,
            'other' => true,
            'none' => true,
            'unknow' => true,
        ]);

        $collumns [] = $question_9 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P5',
            'answers_header' => 'P5 <strong>(RU)</strong> Proximidade (1 a 10)',
            'statement' => '<strong>P5)</strong> Uma das razões de trabalharmos com um fornecedor é nos identificarmos com ele, nos sentirmos próximos deste fornecedor. Sendo assim, gostaríamos de saber o quanto você sente que estes fornecedores têm a ver com a sua empresa.  Vamos usar uma escala de “1” a “10”, onde quanto mais próximo de 10, mais este fornecedor tem a ver com a sua empresa. <strong>(SOMENTE GEA, LIESS, MITECO, TETRAPAK, KHS) (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
            'other' => true,
            'none' => true,
            'unknow' => true,
        ]);
        $question_3->questions()->saveMany($collumns);


        $question_10 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P6',
            'statement' => '<strong>P6)</strong> <strong>(PROCESSOS DE FABRICAÇÃO)</strong> Diga uma palavra que resuma para você quando eu digo... <strong>(ESPONTÂNEO - FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 3,
            'format' => null,
            'order' => 3,
        ]);
        $options_10 = array_slice($options_3, 0, 6, true);
        $question_10->options()->saveMany($options_10);

        $question_11 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P7',
            'statement' => '<strong>P7)</strong> Onde o(a) Sr(a) se informa quando precisa buscar informações sobre <strong>máquinas, equipamentos e soluções de processos</strong> para a sua empresa?',
            'type' => 2,
            'format' => 2,
            'order' => 4,
            'other' => true,
        ]);

        $options_11 = [
            Option::create([
                'statement' => 'Contatando o próprio fabricante',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Em revistas especializadas',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Internet (sites de busca)',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Feiras do setor',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Site do fabricante',
                'value' => 5,
            ]),
        ];
        $question_11->options()->saveMany($options_11);

        $collumns = [];
        $question_12 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'VENDAS DE MÁQUINAS E EQUIPAMENTOS',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 5,
        ]);

        $options_12 = [
            Option::create([
                'statement' => 'Atendimento gentil e educado',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Clareza e objetividade das propostas enviadas',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Tempo de resposta a solicitações e consultas',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Equipe comercial com autonomia para tomar decisões',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Frequência de visitas',
                'value' => 5,
            ]),
            Option::create([
                'statement' => 'Flexibilidade na negociação',
                'value' => 6,
            ]),
        ];
        $question_12->options()->saveMany($options_12);

        $collumns [] = $question_13 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_13 = array_slice($options_3, 0, 6, true);
        $question_13->options()->saveMany($options_13);
        $question_12->questions()->saveMany($collumns);

        $collumns = [];
        $question_14 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'VENDAS DE PEÇAS DE REPOSIÇÃO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 6,
        ]);

        $options_14 = [
            Option::create([
                'statement' => 'Pedido entregue conforme acordado',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Clareza e objetividade das propostas enviadas',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Tempo de resposta a solicitações e consultas',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Equipe comercial com autonomia para tomar decisões',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Frequência de visitas',
                'value' => 5,
            ]),
            Option::create([
                'statement' => 'Cumprimento do prazo de entrega das peças',
                'value' => 6,
            ]),
        ];
        $question_14->options()->saveMany($options_14);

        $collumns [] = $question_15 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_15 = array_slice($options_3, 0, 6, true);
        $question_15->options()->saveMany($options_15);
        $question_14->questions()->saveMany($collumns);


        $collumns = [];
        $question_16 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'ASSISTÊNCIA TÉCNICA',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 7,
        ]);

        $options_16 = [
            Option::create([
                'statement' => 'Capacidade e conhecimento técnico',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Tempo para solução do problema em campo',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Custo do serviço de assistência técnica',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Cordialidade dos técnicos de campo',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Disponibilidade para pronto atendimento',
                'value' => 5,
            ]),
            Option::create([
                'statement' => 'Retorno a solicitações de assistência',
                'value' => 6,
            ]),
        ];
        $question_16->options()->saveMany($options_16);

        $collumns [] = $question_17 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_17 = array_slice($options_3, 0, 6, true);
        $question_17->options()->saveMany($options_17);
        $question_16->questions()->saveMany($collumns);


        $collumns = [];
        $question_18 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'TREINAMENTO TÉCNICO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 8,
        ]);

        $options_18 = [
            Option::create([
                'statement' => 'Qualidade técnica e sua aplicação prática',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Competência Técnica dos Instrutores (didática, postura e conhecimento)',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Custo do treinamento',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Infra - estrutura do Centro de treinamento',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Material didático',
                'value' => 5,
            ]),
            Option::create([
                'statement' => 'Variedade de cursos oferecidos',
                'value' => 6,
            ]),
        ];
        $question_18->options()->saveMany($options_18);

        $collumns [] = $question_19 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_19 = array_slice($options_3, 0, 6, true);
        $question_19->options()->saveMany($options_19);
        $question_18->questions()->saveMany($collumns);


        $collumns = [];
        $question_20 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'POLÍTICA COMERCIAL',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 9,
        ]);

        $options_20 = [
            Option::create([
                'statement' => 'Exigência de Garantias',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Rigidez na cobrança (sendo 10 se é muito rígida e 1 se não há cobrança)',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Vínculo com a variação cambial',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Prazo de pagamento',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Condições de Financiamento',
                'value' => 5,
            ]),
        ];
        $question_20->options()->saveMany($options_20);

        $collumns [] = $question_21 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_21 = array_slice($options_3, 0, 6, true);
        $question_21->options()->saveMany($options_21);
        $question_20->questions()->saveMany($collumns);


        $collumns = [];
        $question_22 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'PRODUTO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 10,
        ]);

        $options_22 = [
            Option::create([
                'statement' => 'Confiabilidade dos equipamentos',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Facilidade de operação dos equipamentos',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Produtividade dos equipamentos',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Nível tecnológico dos equipamentos',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Facilidade de manutenção dos equipamentos',
                'value' => 5,
            ]),
        ];
        $question_22->options()->saveMany($options_22);

        $collumns [] = $question_23 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_23 = array_slice($options_3, 0, 6, true);
        $question_23->options()->saveMany($options_23);
        $question_22->questions()->saveMany($collumns);


        $collumns = [];
        $question_24 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'INSTALAÇÃO E START UP',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 11,
        ]);

        $options_24 = [
            Option::create([
                'statement' => 'Atendimento às normas de segurança',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Cumprimento do prazo combinado para a instalação',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Qualidade da Instalação',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Solução das pendências pós start-up',
                'value' => 4,
            ]),
        ];
        $question_24->options()->saveMany($options_24);

        $collumns [] = $question_25 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_25 = array_slice($options_3, 0, 6, true);
        $question_25->options()->saveMany($options_25);
        $question_24->questions()->saveMany($collumns);


        $collumns = [];
        $question_26 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'SUPORTE TÉCNICO TELEFÔNICO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong>(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 12,
        ]);

        $options_26 = [
            Option::create([
                'statement' => 'Horário de atendimento',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Plantão de peças',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Postura do especialista, empenho na busca de soluções',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Capacidade e conhecimento técnico do especialista',
                'value' => 4,
            ]),
        ];
        $question_26->options()->saveMany($options_26);

        $collumns [] = $question_27 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong>(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_27 = array_slice($options_3, 0, 6, true);
        $question_27->options()->saveMany($options_27);
        $question_26->questions()->saveMany($collumns);


        $question_28 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P10',
            'answers_header' => 'P10 (RU) Ordem Importância',
            'statement' => '<strong>P10)</strong> Agora que já avaliamos os atributos dentro dos fatores, gostaria que você me dissesse o quanto cada fator é importante no momento de decidir trabalhar com um <strong>fornecedor de máquinas, equipamentos e soluções para o seu mercado.</strong> Assim, qual desses fatores é mais importante em 1° lugar? E em 2°? E em 3°? E assim por diante. <strong>(FAÇA PERGUNTA ATÉ O 8º LUGAR)</strong>',
            'type' => 4,
            'format' => 2,
            'order' => 13,
        ]);

        $options_28 = [
            Option::create([
                'statement' => 'VENDAS DE MÁQUINAS E EQUIPAMENTOS',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'VENDAS DE PEÇAS DE REPOSIÇÃO',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'ASSISTÊNCIA TÉCNICA',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'TREINAMENTO TÉCNICO',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'POLÍTICA COMERCIAL',
                'value' => 5,
            ]),
            Option::create([
                'statement' => 'PRODUTO',
                'value' => 6,
            ]),
            Option::create([
                'statement' => 'INSTALAÇÃO E START UP',
                'value' => 7,
            ]),
            Option::create([
                'statement' => 'SUPORTE TÉCNICO TELEFÔNICO',
                'value' => 8,
            ]),
        ];
        $question_28->options()->saveMany($options_28);


        $collumns = [];
        $question_29 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P11',
            'options_header' => 'FATORES DE IMAGEM',
            'answers_header' => 'P11 Ordem Importância',
            'statement' => '<strong>P11)</strong> As empresas em geral buscam ter uma boa imagem, serem respeitadas e admiradas. A seguir vou ler uma série de fatores que são considerados relevantes para este objetivo. Gostaríamos que você colocasse estes fatores em ordem de importância, do 1º ao 4º lugar.',
            'type' => 4,
            'format' => 3,
            'order' => 14,
        ]);

        $options_29 = [
            Option::create([
                'statement' => 'Política Sócio Ambiental',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Inovação & Tecnologia',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Solidez',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Parceria',
                'value' => 4,
            ]),
        ];
        $question_29->options()->saveMany($options_29);

        $collumns [] = $question_30 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P12',
            'answers_header' => 'P12',
            'statement' => '<strong>P12)</strong> Agora, vamos avaliar a imagem das mesmas empresas avaliadas na satisfação em relação a cada um destes Fatores, mesmo que não tenha trabalhado com a empresa. Para isso vamos utilizar novamente a escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS o fornecedor está em linha com sua expectativa</strong> em relação ao fator, e quanto mais próximo do 10, <strong>MAIS o fornecedor está em linha com sua expectativa.</strong> Pensando na Krones, qual nota você dá para ela em relação ao fator... E para a...? <strong>(AVALIAR TODAS AS EMPRESAS ) (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $options_30 = array_slice($options_3, 0, 6, true);
        $question_30->options()->saveMany($options_30);
        $question_29->questions()->saveMany($collumns);


        $question_31 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P13',
            'options_header' => 'P13 - Recomendação',
            'answers_header' => 'P13',
            'statement' => '<strong>P13)</strong> <strong>(AVALIAR AS EMPRESAS QUE TRABALHAM – CITADAS NA P3)</strong> Utilizando a escala de 1 a 10, na qual 1 significa <strong>“Certamente Não recomendaria”</strong> e 10 significa <strong>“Certamente Recomendaria”</strong>, o quanto você <strong>recomendaria a...? (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => 2,
            'order' => 15,
        ]);
        $options_31 = array_slice($options_3, 0, 6, true);
        $question_31->options()->saveMany($options_31);


        $question_32 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P14',
            'options_header' => 'P14 – Ampliar negócios',
            'answers_header' => 'P14',
            'statement' => '<strong>P14)</strong> <strong>(AVALIAR AS EMPRESAS QUE TRABALHAM – CITADAS NA P3)</strong> Utilizando esta mesma escala de 1 a 10, o quanto você <strong>pretende ampliar os negócios com a... ? (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => 2,
            'order' => 16,
        ]);
        $options_32 = array_slice($options_3, 0, 6, true);
        $question_32->options()->saveMany($options_32);


        $collumns = [];
        $question_33 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P15',
            'options_header' => '',
            'answers_header' => 'Krones',
            'statement' => '<strong>P15)</strong> Falando sobre custo/benefício, como você classificaria os produtos e serviços da Krones, e da ...? <strong>(LEIA TODAS AS ALTERNATIVAS E TODAS AS EMPRESAS) (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 1,
            'format' => 3,
            'order' => 17,
        ]);
        $options_33 = [
            Option::create([
                'statement' => 'Bem competitivo',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Aceitável, um bom custo/benefício',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Adequado, alinhado com o mercado',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Acima do mercado',
                'value' => 4,
            ]),
            Option::create([
                'statement' => 'Muito acima do mercado',
                'value' => 5,
            ]),
        ];
        $question_33->options()->saveMany($options_33);

        $collumns [] = $question_34 = Question::create([
            'survey_id' => $survey->id,
            'name' => '',
            'answers_header' => 'Gea',
            'statement' => null,
            'type' => 1,
            'format' => null,
        ]);

        $collumns [] = $question_35 = Question::create([
            'survey_id' => $survey->id,
            'name' => '',
            'answers_header' => 'Liess',
            'statement' => null,
            'type' => 1,
            'format' => null,
        ]);

        $collumns [] = $question_36 = Question::create([
            'survey_id' => $survey->id,
            'name' => '',
            'answers_header' => 'KHS',
            'statement' => null,
            'type' => 1,
            'format' => null,
        ]);

        $collumns [] = $question_37 = Question::create([
            'survey_id' => $survey->id,
            'name' => '',
            'answers_header' => 'Miteco',
            'statement' => null,
            'type' => 1,
            'format' => null,
        ]);

        $collumns [] = $question_38 = Question::create([
            'survey_id' => $survey->id,
            'name' => '',
            'answers_header' => 'Tetrapak',
            'statement' => null,
            'type' => 1,
            'format' => null,
        ]);
        $question_33->questions()->saveMany($collumns);


        $question_39 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P16',
            'answers_header' => 'P16 <strong>(RU)</strong>',
            'statement' => '<strong>P16)</strong> <strong>(SOMENTE PARA NÃO CLIENTES)</strong> Esta pesquisa foi encomendada pela Krones. Você aceita receber uma visita ou um contato da Krones?',
            'type' => 1,
            'format' => 2,
            'order' => 18,
        ]);
        $options_39 = [
            Option::create([
                'statement' => 'VISITA',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'APENAS UM CONTATO',
                'value' => 2,
            ]),
        ];
        $question_39->options()->saveMany($options_39);



        $question_40 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P17',
            'answers_header' => 'P17 <strong>(RU)</strong>',
            'statement' => '<strong>P17)</strong> <strong>(SOMENTE PARA CLIENTES)</strong> Na reposição de peças, quanto em percentual você utiliza de peças originais da Krones?',
            'type' => 1,
            'format' => 2,
            'order' => 19,
        ]);
        $options_40 = [
            Option::create([
                'statement' => 'Abaixo de 30%',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'Entre 30 e 50%',
                'value' => 2,
            ]),
            Option::create([
                'statement' => 'Entre 50 e 70%',
                'value' => 3,
            ]),
            Option::create([
                'statement' => 'Acima de 70%',
                'value' => 4,
            ]),
        ];
        $question_40->options()->saveMany($options_40);



        $question_41 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P18',
            'answers_header' => 'P18 <strong>(RU)</strong>',
            'statement' => '<strong>P18)</strong> <strong>(SOMENTE PARA CLIENTES)</strong> Você utiliza ou já utilizou as válvulas EVOGUARD DA KRONES?',
            'type' => 1,
            'format' => 2,
            'order' => 20,
        ]);
        $options_41 = [
            Option::create([
                'statement' => 'SIM',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'NÃO',
                'value' => 2,
            ]),
        ];
        $question_41->options()->saveMany($options_41);


        $question_42 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P19',
            'answers_header' => 'P19 <strong>(RU)</strong>',
            'statement' => '<strong>P19)</strong> <strong>(SE NÃO)</strong> Você aceita receber uma visita ou um contato da Krones para conhecer as VÁLVULAS EVOGUARD?',
            'type' => 1,
            'format' => 2,
            'order' => 21,
        ]);
        $options_42 = [
            Option::create([
                'statement' => 'VISITA',
                'value' => 1,
            ]),
            Option::create([
                'statement' => 'APENAS UM CONTATO',
                'value' => 2,
            ]),
        ];
        $question_42->options()->saveMany($options_42);


        $question_43 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P21',
            'statement' => '<strong>P21)</strong> Esta pesquisa foi encomendada pela Krones do Brasil, para finalizar que mensagem você mandaria à diretoria da Krones?',
            'type' => 3,
            'format' => null,
            'order' => 22,
        ]);


        $condition_1 = [];
        $condition_2 = [];
        $condition_3 = [];
        $condition_4 = [];
        $condition_5 = [];
        $condition_6 = [];
        $condition_7 = [];
        $condition_8 = [];
        foreach (array_slice($options_3,0,6,true) as $key => $condition){
            $condition_1 [] = App\Condition::create([
                'question_id' => $question_3->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_10->id,
                'to_option_id' => $options_10[$key]->id,
                'show' => true,
            ]);

            $condition_2 [] = App\Condition::create([
                'question_id' => $question_4->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_10->id,
                'to_option_id' => $options_10[$key]->id,
                'show' => true,
            ]);

            $condition_3 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_13->id,
                'to_option_id' => $options_13[$key]->id,
                'show' => true,
            ]);

            $condition_4 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_15->id,
                'to_option_id' => $options_15[$key]->id,
                'show' => true,
            ]);

            $condition_5 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_17->id,
                'to_option_id' => $options_17[$key]->id,
                'show' => true,
            ]);

            $condition_6 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_19->id,
                'to_option_id' => $options_19[$key]->id,
                'show' => true,
            ]);

            $condition_7 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_21->id,
                'to_option_id' => $options_21[$key]->id,
                'show' => true,
            ]);

            $condition_8 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_23->id,
                'to_option_id' => $options_23[$key]->id,
                'show' => true,
            ]);

            $condition_9 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_25->id,
                'to_option_id' => $options_25[$key]->id,
                'show' => true,
            ]);

            $condition_10 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_27->id,
                'to_option_id' => $options_27[$key]->id,
                'show' => true,
            ]);

            $condition_11 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_30->id,
                'to_option_id' => $options_30[$key]->id,
                'show' => true,
            ]);

            $condition_12 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_31->id,
                'to_option_id' => $options_31[$key]->id,
                'show' => true,
            ]);

            $condition_13 [] = Condition::create([
                'question_id' => $question_6->id,
                'option_id' => $condition->id,
                'to_question_id' => $question_32->id,
                'to_option_id' => $options_32[$key]->id,
                'show' => true,
            ]);

        }

        $condition_14 = Condition::create([
            'question_id' => $question_6->id,
            'option_id' => $options_3[0]->id,
            'to_question_id' => $question_33->id,
            'show' => true,
        ]);

        $condition_15 = Condition::create([
            'question_id' => $question_6->id,
            'option_id' => $options_3[1]->id,
            'to_question_id' => $question_34->id,
            'show' => true,
        ]);

        $condition_16 = Condition::create([
            'question_id' => $question_6->id,
            'option_id' => $options_3[2]->id,
            'to_question_id' => $question_35->id,
            'show' => true,
        ]);

        $condition_17 = Condition::create([
            'question_id' => $question_6->id,
            'option_id' => $options_3[3]->id,
            'to_question_id' => $question_36->id,
            'show' => true,
        ]);

        $condition_18 = Condition::create([
            'question_id' => $question_6->id,
            'option_id' => $options_3[4]->id,
            'to_question_id' => $question_37->id,
            'show' => true,
        ]);

        $condition_19 = Condition::create([
            'question_id' => $question_6->id,
            'option_id' => $options_3[5]->id,
            'to_question_id' => $question_38->id,
            'show' => true,
        ]);

        $condition_20 = Condition::create([
            'question_id' => $question_1->id,
            'option_id' => $options_1[1]->id,
            'to_question_id' => $question_39->id,
            'show' => true,
        ]);

        $condition_21 = Condition::create([
            'question_id' => $question_1->id,
            'option_id' => $options_1[0]->id,
            'to_question_id' => $question_40->id,
            'show' => true,
        ]);

        $condition_22 = Condition::create([
            'question_id' => $question_1->id,
            'option_id' => $options_1[0]->id,
            'to_question_id' => $question_41->id,
            'show' => true,
        ]);

        $condition_23 = Condition::create([
            'question_id' => $question_41->id,
            'option_id' => $options_41[1]->id,
            'to_question_id' => $question_42->id,
            'show' => true,
        ]);

    }
}
