<?php

use App\Survey;
use App\Option;
use App\Question;
use App\Condition;
use App\Sample;
use App\Subject;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KronesInternoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $survey = Survey::create([
            'name' => 'Krones Interno',
            'type' => 1,
            'intro' => '<p>Olá, a H2M Estudos Estratégicos, consultoria que desenvolve estudos estratégicos, foi contratada para realizar uma pesquisa sobre a <strong>Satisfação e Imagem da Krones como fornecedor de máquinas, equipamentos e soluções para o mercado de bebidas, alimentos, químicos, cosméticos, farmacêuticos e transformadores</strong>, e nós gostaríamos de saber sua opinião a respeito de alguns aspectos do dia a dia do negócio.</p><p>É importante que você saiba que suas informações são sigilosas e serão analisadas em conjunto com as informações dos demais entrevistados que fazem parte da nossa amostra.</p><p>Não se preocupe com a numeração das perguntas, que não necessariamente é sequencial por questões do processamento.</p>',
            'init_at' => Carbon::now()->addDays(1),
            'end_at' => Carbon::now()->addDays(30),
            'active' => true,
        ]);


        $collumns = [];
        $question_1 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'VENDAS DE MÁQUINAS E EQUIPAMENTOS',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 0,
        ]);

        $options_1 = [
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
        $question_1->options()->saveMany($options_1);

        $collumns [] = $question_2 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_1->questions()->saveMany($collumns);

        $collumns = [];
        $question_3 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'VENDAS DE PEÇAS DE REPOSIÇÃO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 1,
        ]);

        $options_3 = [
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
        $question_3->options()->saveMany($options_3);

        $collumns [] = $question_4 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_3->questions()->saveMany($collumns);


        $collumns = [];
        $question_5 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'ASSISTÊNCIA TÉCNICA',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 2,
        ]);

        $options_5 = [
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
        $question_5->options()->saveMany($options_5);

        $collumns [] = $question_6 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_5->questions()->saveMany($collumns);


        $collumns = [];
        $question_7 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'TREINAMENTO TÉCNICO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 3,
        ]);

        $options_7 = [
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
        $question_7->options()->saveMany($options_7);

        $collumns [] = $question_8 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_7->questions()->saveMany($collumns);


        $collumns = [];
        $question_9 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'POLÍTICA COMERCIAL',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 4,
        ]);

        $options_9 = [
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
        $question_9->options()->saveMany($options_9);

        $collumns [] = $question_10 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_9->questions()->saveMany($collumns);


        $collumns = [];
        $question_11 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'PRODUTO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 5,
        ]);

        $options_11 = [
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
        $question_11->options()->saveMany($options_11);

        $collumns [] = $question_12 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_11->questions()->saveMany($collumns);


        $collumns = [];
        $question_13 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'INSTALAÇÃO E START UP',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 6,
        ]);

        $options_13 = [
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
        $question_13->options()->saveMany($options_13);

        $collumns [] = $question_14 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_13->questions()->saveMany($collumns);


        $collumns = [];
        $question_15 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P8',
            'options_header' => 'SUPORTE TÉCNICO TELEFÔNICO',
            'answers_header' => 'Import. Atributos',
            'statement' => '<strong>P8)</strong> Na relação de um fornecedor e seus clientes, existem alguns fatores e atributos que são importantes na escolha deste fornecedor. Primeiro vamos classificar os atributos em ordem de importância dentro de cada fator. Assim, na escolha de um fornecedor qual atributo você acha mais importante em 1º lugar? Em 2º em 3° e assim por diante <strong class="text-danger">(LER OS ATRIBUTOS DE CADA FATOR E ORDENAR DENTRO DE CADA FATOR)</strong>',
            'type' => 4,
            'format' => 3,
            'order' => 7,
        ]);

        $options_15 = [
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
        $question_15->options()->saveMany($options_15);

        $collumns [] = $question_16 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P9',
            'answers_header' => 'P9',
            'statement' => '<strong>P9)</strong> Agora vamos avaliar a sua satisfação com alguns fornecedores que você trabalha em relação a cada um destes Atributos que acabou de ordenar. Para isso vamos utilizar uma escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS SATISFEITO</strong> você está, e quanto mais próximo do 10, <strong>MAIS SATISFEITO</strong> você está com o fornecedor. Sendo assim o quanto você está satisfeito com a.... <strong class="text-danger">(SOMENTE AVALIA AS EMPRESAS CITADAS NA P3 – FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_15->questions()->saveMany($collumns);


        $question_17 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P10',
            'answers_header' => 'P10 (RU) Ordem Importância',
            'statement' => '<strong>P10)</strong> Agora que já avaliamos os atributos dentro dos fatores, gostaria que você me dissesse o quanto cada fator é importante no momento de decidir trabalhar com um <strong>fornecedor de máquinas, equipamentos e soluções para o seu mercado.</strong> Assim, qual desses fatores é mais importante em 1° lugar? E em 2°? E em 3°? E assim por diante. <strong class="text-danger">(FAÇA PERGUNTA ATÉ O 8º LUGAR)</strong>',
            'type' => 4,
            'format' => 2,
            'order' => 8,
        ]);

        $options_17 = [
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
        $question_17->options()->saveMany($options_17);


        $collumns = [];
        $question_18 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P11',
            'options_header' => 'FATORES DE IMAGEM',
            'answers_header' => 'P11 Ordem Importância',
            'statement' => '<strong>P11)</strong> As empresas em geral buscam ter uma boa imagem, serem respeitadas e admiradas. A seguir vou ler uma série de fatores que são considerados relevantes para este objetivo. Gostaríamos que você colocasse estes fatores em ordem de importância, do 1º ao 4º lugar.',
            'type' => 4,
            'format' => 3,
            'order' => 9,
        ]);

        $options_18 = [
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
        $question_18->options()->saveMany($options_18);

        $collumns [] = $question_19 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P12',
            'answers_header' => 'P12',
            'statement' => '<strong>P12)</strong> Agora, vamos avaliar a imagem das mesmas empresas avaliadas na satisfação em relação a cada um destes Fatores, mesmo que não tenha trabalhado com a empresa. Para isso vamos utilizar novamente a escala de 1 a 10, onde quanto mais próximo do 1 <strong>MENOS o fornecedor está em linha com sua expectativa</strong> em relação ao fator, e quanto mais próximo do 10, <strong>MAIS o fornecedor está em linha com sua expectativa.</strong> Pensando na Krones, qual nota você dá para ela em relação ao fator... E para a...? <strong class="text-danger">(AVALIAR TODAS AS EMPRESAS ) (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 5,
            'format' => null,
        ]);
        $question_18->questions()->saveMany($collumns);


        $question_20 = Question::create([
            'survey_id' => $survey->id,
            'name' => 'P15',
            'options_header' => '',
            'answers_header' => 'Krones',
            'statement' => '<strong>P15)</strong> Falando sobre custo/benefício, como você classificaria os produtos e serviços da Krones, e da ...? <strong class="text-danger">(LEIA TODAS AS ALTERNATIVAS E TODAS AS EMPRESAS) (FAZER RODÍZIO DAS MARCAS)</strong>',
            'type' => 1,
            'format' => 3,
            'order' => 10,
        ]);
        $options_20 = [
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
        $question_20->options()->saveMany($options_20);


        $sample = Sample::create(['name' => 'Krones Interno']);

        $subjects = [];

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Silvio Rotta',
            'email' => 'silvio.rotta@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Diretor Comercial',
            'telephone' => '11 4075-9630 / 11 8245-2385',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Nelson Ferreira',
            'email' => 'nelson.ferreira@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente Comercial',
            'telephone' => '11 4075-9566 / 11 8218-8883',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Renato Brandão',
            'email' => 'renato.brandao@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente RH / TI / Controladoria',
            'telephone' => '11 4075-9572 / 11 8244-4972',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Sandro Cubo',
            'email' => 'sandro.cubo@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente Service',
            'telephone' => '11 4075-9579 / 11 8253-7774',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Ayrton Irokawa',
            'email' => 'ayrton.irokawa@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente Comercial',
            'telephone' => '11 4075-9588 / 11 8245-9791',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Christoph Lanfer',
            'email' => 'christoph.lanfer@krones.com',
            'company' => 'Krones AG',
            'ocupation' => 'Diretor Vendas - Krones AG',
            'telephone' => '+49 9401 70 2748',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Jakob Anton Wolf',
            'email' => 'jakob.wolf@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Diretor Industrial',
            'telephone' => '11 4075-9725/ 11 8242-9888',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Jens Hoyer',
            'email' => 'jens.hoyer@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Presidente',
            'telephone' => '11 4075-9501',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Ricardo Capellari',
            'email' => 'ricardo.capellari@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Supervisor de Vendas - Kits',
            'telephone' => '11 4075-9693 / 11 8224-3716',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Sandro Tadeu',
            'email' => 'sandro.tadeu@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Supervisor Layout',
            'telephone' => '11 4075-9583 / 11 8571-4903',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Thiago Sugiura',
            'email' => 'thiago.sugiura@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Coordenador Marketing',
            'telephone' => '11 4075-9504 / 11 8178-0848',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Sandro Pereira',
            'email' => 'sandro.pereira@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente Industrial',
            'telephone' => '11 4075-9527',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Alexandrim Gatti',
            'email' => 'alexandrim.gatti@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente Financeiro',
            'telephone' => '11 4075-9612 / 011-8244-4986',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Lars Junge',
            'email' => 'lars.junge@krones.com',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente Service',
            'telephone' => '11 4075-9612 / 011-8244-4986',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Rodrigo Picheco',
            'email' => 'rodrigo.picheco@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Supervisor de Peças',
            'telephone' => '11 4075-9522 / 011-8218-5211',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Claudia Orsolon',
            'email' => 'claudia-braga.orsolon@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Gerente de Logística',
            'telephone' => '11 4075-9673 / 11 98264-9133',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Maxwell Pereira',
            'email' => 'maxwell.pereira@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Supervisor de Vendas',
            'telephone' => '11 4075-9631 / 11 98244-4947',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Adriano Nazutto',
            'email' => 'adriano.nazutto@krones.com.br',
            'company' => 'Krones do Brasil',
            'ocupation' => 'Supervisor de Vendas',
            'telephone' => '11 4075-9633 / 11 98355-2001',
        ]);

        $subjects [] = Subject::create([
            'user_id' => 1,
            'name' => 'Helio Portela',
            'email' => 'helio.portela@krones.com',
            'company' => 'Krones AG',
            'ocupation' => 'Diretor LCS - Krones AG',
            'telephone' => '+49 151 11317458',
        ]);

        $sample->subjects()->saveMany($subjects);




    }
}
