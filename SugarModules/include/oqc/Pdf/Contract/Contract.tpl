% Preamble- set Latex document global typeset. Modifying it will affect all pdfs created with oqc 


<if "it_it" == $default_language>

% Italian 
\documentclass[10pt,a4paper,italian,parskip,headsepline,DIV14]{scrartcl}
\usepackage[italian]{babel}						

<else> <if "ge_ge" == $default_language>

% German 
\documentclass[10pt,a4paper,german,parskip,headsepline,DIV14]{scrartcl}
\usepackage[ngerman]{babel}						

<else> <if "ru_ru" == $default_language>

% Russian
\documentclass[12pt,a4paper,english,parskip,headsepline,DIV14]{scrartcl}
\usepackage[russian, english]{babel}	

<else>

% English
\documentclass[10pt,a4paper,english,parskip,headsepline,DIV14]{scrartcl}
\usepackage[english]{babel}						

</if>
</if>
</if>

\usepackage[utf8]{inputenc} % this sets input file encoding; it is recommended to use utf-8 for all new projects
\usepackage[T1]{fontenc} % Set required fonts encoding; refer to Latex Manual for more info
\usepackage{longtable}
\usepackage{booktabs}
\usepackage{scrpage2}
\usepackage{typearea}
\usepackage{graphicx,ifthen} % allows graphics insertion and manipulation
\usepackage{eurosym}
\usepackage{pdflscape}
\usepackage{ifpdf}
\usepackage{fixltx2e} % allows subscript
\usepackage[normalem]{ulem} % allows underline and strikeout

\pagestyle{scrheadings}

% NOTE: this requires graphicx and ifthen to be loaded!! 
% if image width does not exceed \textwidth it should be displayed in original size. otherwise its width should be scaled to \textwidth 
% to use this functionality use \pitpic instead of \includegraphics when inserting your images! 

\newlength{\testwd}
\newcommand{\fitpic}[1]{%
\settowidth{\testwd}{\includegraphics{#1}}%
\message{#1 width=\the\testwd, page=\the\textwidth}%
\ifthenelse{\lengthtest{\testwd>\textwidth}}{%
\noindent\includegraphics[width=\textwidth]{#1}}{%
\centering\includegraphics{#1}\par}%
}


% decrease left page margin and increase page width. this is useful for wide tables and images 
\addtolength{\textwidth}{+0.7in}
\addtolength{\textheight}{+0.7in}
\addtolength{\oddsidemargin}{-0.2in}


% match html paragraph indent width
\setlength\parindent{0in}

% End of preamble 

\begin{document}

<if isset($titlePage)>
	\newpage
	<fetch file=$titlePage>
</if>

<if isset($textBlocks)>
	\newpage
	<fetch file=$textBlocks>
</if>

<if isset($services)>
	\newpage
	<fetch file=$services>
</if>

\end{document}

