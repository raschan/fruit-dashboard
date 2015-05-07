<p>snake case</p>
<h1>{{ snake_case('Pappara ram') }}</h1>
<h1>{{ snake_case('Pappara Ram') }}</h1>
<h1>{{ snake_case('PapparaRam') }}</h1>
<p>camel case</p>
<h1>{{ camel_case('Pappara ram') }}</h1>
<h1>{{ camel_case('Pappara Ram') }}</h1>
<h1>{{ camel_case('PapparaRam') }}</h1>
<p>snaked camel case</p>
<h1>{{ snake_case(camel_case('PapparaRam')) }}</h1>
<h1>{{ snake_case(camel_case('Pappara ram')) }}</h1>