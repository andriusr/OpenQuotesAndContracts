<*
  * TextBlocks LaTeX template
  *>

\subsection*{Remarks}
\textbf{Notes regarding our proposal above:}
<if is_array($filenames) && count($filenames) != 0>
	\begin{enumerate}
	<foreach item=filename from=$filenames>
		\item 
  <fetch file=$filename>
	</foreach>
	\end{enumerate}
</if>
