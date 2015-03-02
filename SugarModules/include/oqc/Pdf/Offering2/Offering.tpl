% Preamble- this part of file determines global parameters of document
% This file was converted to LaTeX by Writer2LaTeX ver. 1.1.8
% see http://writer2latex.sourceforge.net for more info
\documentclass[10pt,a4paper,english,parskip,headsepline,DIV14]{scrartcl}

%\documentclass[a4paper,landscape]{article} %removed landscape, added 10 pt font size, english for language
\usepackage[english]{babel} %hyphenation
\usepackage[utf8]{inputenc} %change the input encoding- utf8 is recomennded for new projects
\usepackage[T1]{fontenc}
\usepackage{amsmath}
\usepackage{amssymb,amsfonts,textcomp}
\usepackage{color}
\usepackage{array}
\usepackage{supertabular}
\usepackage{hhline}
\usepackage{hyperref}
\usepackage{fixltx2e} % allows subscript
\usepackage[normalem]{ulem} % allows underline and strikeout
\usepackage[pdftex]{graphicx}
\usepackage{eurosym} %this is required for euro symbol display
\usepackage{pdflscape} % enables landscape page orientation when used

%\hypersetup{pdftex, colorlinks=true, linkcolor=blue, citecolor=blue, filecolor=blue, urlcolor=blue, pdftitle=, pdfauthor=, pdfsubject=, pdfkeywords=}

\makeatletter
\newcommand\arraybslash{\let\\\@arraycr}
\makeatother
% Page layout (geometry) changes to increase printable area
\setlength\voffset{-0.5in}
\setlength\hoffset{-0.5in}
\setlength\topmargin{1cm}
\setlength\oddsidemargin{1cm}
\setlength\textheight{25.7cm}
\setlength\textwidth{18.001cm}
\setlength\footskip{0.0cm}
\setlength\headheight{0cm}
\setlength\headsep{0cm}
% Footnote rule
\setlength{\skip\footins}{0.119cm}
\renewcommand\footnoterule{\vspace*{-0.018cm}\setlength\leftskip{0pt}\setlength\rightskip{0pt plus 1fil}\noindent\textcolor{black}{\rule{0.25\columnwidth}{0.018cm}}\vspace*{0.101cm}}
% Page styles
\makeatletter
%disables headers and footers
\newcommand\ps@Standard{
  \renewcommand\@oddhead{}
  \renewcommand\@evenhead{}
  \renewcommand\@oddfoot{}
  \renewcommand\@evenfoot{}
  \renewcommand\thepage{\arabic{page}}
}
\makeatother
\pagestyle{Standard}
\setlength\tabcolsep{1mm}
\renewcommand\arraystretch{1.3}

% End of preamble 

\begin{document}

% Title page is not required

<if isset($services)>
	\newpage
	<fetch file=$services>
</if>

%textblocks are included after services
<if isset($textBlocks)>
	\newpage
	<fetch file=$textBlocks>
</if>

% After services the attachements are included that have appropriate settings of document purpose field. If You do not want to attach files, set document purpose to "For internal use".
\end{document}

