<* NOTE: this requires graphicx and ifthen to be loaded!! *>

<* if image width does not exceed \textwidth it should be displayed in original size. otherwise its width should be scaled to \textwidth *>
<* to use this functionality use \pitpic instead of \includegraphics when inserting your images! *>
\newlength{\testwd}
\newcommand{\fitpic}[1]{%
\settowidth{\testwd}{\includegraphics{#1}}%
\message{#1 width=\the\testwd, page=\the\textwidth}%
\ifthenelse{\lengthtest{\testwd>\textwidth}}{%
\noindent\includegraphics[width=\textwidth]{#1}}{%
\centering\includegraphics{#1}\par}%
}