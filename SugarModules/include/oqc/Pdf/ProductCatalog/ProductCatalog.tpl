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

% NOTE: if you want to use the ids of beans to create labels and reference them later, remove the "-" from the id when you use it. see the existing examples in the product catalog for more information 

\usepackage[utf8]{inputenc}
\usepackage{longtable}
\usepackage{booktabs}
\usepackage{scrpage2}
\usepackage{typearea}
\usepackage{graphicx,ifthen}
\usepackage{eurosym}
\usepackage{pdflscape}
\usepackage{ifpdf}
\usepackage{ulem}
\usepackage{pdfpages}
\usepackage{titlesec}


\pagestyle{scrheadings}
\manualmark

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

\ifpdf
\pdfinfo {
	/Author (<$pdfCompanyName>)
	/Title (<$language.pdf.catalog.title>)
	/Subject (<$pdfCompanyName> <$language.pdf.catalog.title>)
}
\fi


% match LEV indent width
\setlength\parindent{0in}
% decrease left page margin and increase page width. this is useful for wide tables and images 
\addtolength{\textwidth}{+0.7in}
\addtolength{\textheight}{+0.7in}
\addtolength{\oddsidemargin}{-0.2in}



\begin{document}

% header and footer

\ohead{<$pdfCompanyName> <$language.pdf.catalog.title>}
\ifoot{<$pdfCompanyName> <$language.pdf.catalog.title>}
\cfoot{}
\ofoot{\pagemark}

% frontpage

<if empty($frontpage)>
	\titlehead{\includegraphics[scale=0.9]{<$graphicsDir>bb.png} \hfill \includegraphics[scale=0.72]{<$graphicsDir>lds.png}}
	\title{<$language.pdf.catalog.title>\\ <$pdfCompanyName>}
	\maketitle
<else>
	\includepdf[fitpaper=true,pages=-]{<$frontpage>}
</if>

% generate table of content entries up to level 4 (paragraph)
\setcounter{tocdepth}{4}

% also enumerate subsubsection, paragraph and subparagraph
\setcounter{secnumdepth}{5}

\titlespacing*{\section}{0em}{*4}{*1.5}
\titleformat{\section}{\sffamily\bfseries\vspace\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesection}}{0em}{}[\vspace{0.7ex}\titlerule]
\titleformat{\subsection}{\sffamily\bfseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesubsection}}{0em}{}[\vspace{0.7ex}\titlerule]
\titleformat{\subsubsection}{\sffamily\bfseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesubsubsection}}{0em}{}[\vspace{0.7ex}\titlerule]
\titleformat{\paragraph}{\itshape\bfseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\theparagraph}}{0em}{}[\vspace{0.7ex}\titlerule]
\titleformat{\subparagraph}{\itshape\mdseries\titlerule\vspace{0.7ex}}{\makebox[5em][l]{\thesubparagraph}}{0em}{}[\vspace{0.7ex}\titlerule]

\newcommand{\subsubsubsection}{\paragraph}
\newcommand{\subsubsubsubsection}{\subparagraph}

% do not include chapter numbers in section numbers; chapters does not exist in this document class
%\renewcommand{\thechapter}{\Roman{chapter}}
\renewcommand{\thesection}{\arabic{section}}

% break long underlined lines
\renewcommand{\underbar}{\uline}

\chapter{\textbf{<$language.pdf.catalog.publisherTitle>}}

<$pdfCompanyAddress>

\begin{tabbing}
<$pdfCompanyContactPhone> \\
<$pdfCompanyContactFax> \\
<$pdfCompanyContactMail> \\
<$pdfCompanyContactInternet> \\
\end{tabbing}
\begin{tabbing}

<$pdfCopyrightNotice>

\end{tabbing}

\newpage

\tableofcontents

<include file="include/oqc/Pdf/ProductCatalog/Intro.tpl">
<include file="include/oqc/Pdf/ProductCatalog/Contact.tpl">
<include file="include/oqc/Pdf/ProductCatalog/Validity.tpl">

\newcounter{oqc_pn}
\newcounter{oqc_opt}

\section*{\textbf{<$language.pdf.catalog.services>}}
<include file="include/oqc/Pdf/ProductCatalog/Categories.tpl" rootCategories=$categoriesAndProducts section="section" counter="">

<include file="include/oqc/Pdf/ProductCatalog/ProductTables.tpl" rootCategories=$categoriesAndProducts section="section">
\newpage
<include file="include/oqc/Pdf/ProductCatalog/ProductImages.tpl" rootCategories=$categoriesAndProducts section="section">

% attachment
<if not empty($attachment)>
	\includepdf[pagecommand={},pages=-]{<$attachment>}
</if>

\end{document}
