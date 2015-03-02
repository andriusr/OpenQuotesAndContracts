<if "it_it" == $default_language>

<* italian *>
\documentclass[12pt,a4paper,italian,parskip,headsepline,DIV14]{scrartcl}
\usepackage[italian]{babel}						<* usepackage for italian *>

<else> <if "ge_ge" == $default_language>

<* german *>
\documentclass[12pt,a4paper,german,parskip,headsepline,DIV14]{scrartcl}
\usepackage[ngerman]{babel}						<* usepackage for german *>

<else> <if "ru_ru" == $default_language>

% Russian
\documentclass[12pt,a4paper,english,parskip,headsepline,DIV14]{scrartcl}
\usepackage[russian, english]{babel}	

<else>

<* english *>
\documentclass[12pt,a4paper,english,parskip,headsepline,DIV14]{scrartcl}
\usepackage[english]{babel}						<* fallback: usepackage for english *>

</if>
</if>
</if>