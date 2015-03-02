<*
  * TextBlocks LaTeX template
  *
  *>

\subsection*{<$language.pdf.contract.preamble>}

<$language.pdf.contract.preamble>

<$language.pdf.contract.textblocksIntro>
<if is_array($filenames) && count($filenames) != 0>

	\begin{enumerate}

	<foreach item=filename from=$filenames>
		\item 
  <fetch file=$filename>
	</foreach>
	\end{enumerate}
</if>
