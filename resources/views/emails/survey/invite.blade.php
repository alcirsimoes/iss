@component('mail::message')
# Convite

Prezado {{ $subject->name }},
Recentemente a Krones decidiu realizar uma pesquisa de Satisfação de Cliente e Imagem da Krones. Essa iniciativa irá auxiliar a identificar como a Krones e seus principais concorrentes são avaliados no mercado. Gostaríamos, no entanto, de poder comparar a visão do mercado com a visão interna, ou seja, como os colaboradores enxergam e avaliam a atuação da empresa.

Por favor, responda o questionário utilizando o link: {{ $survey->name }}

Em caso de dúvida entre em contato conosco através do e-mail: w.horstmann@h2mbrasil.com

É importante que você saiba que as suas informações são sigilosas e serão analisadas, pela H2M, em conjunto com as informações dos demais entrevistados que fazem parte da amostra.

Sua participação é fundamental para o sucesso da pesquisa!

@component('mail::button', ['url' => ''])
Responder
@endcomponent

Atenciosamente,<br>

William Horstmann<br>

H2M Estudos Estratégicos Ltda.
@endcomponent
