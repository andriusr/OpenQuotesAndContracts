<*
  * Title page LaTeX template
  *
  *>


\ihead{<$language.pdf.contract.quote_title> <$contract.svnumber>}

\titlehead{\includegraphics[scale=0.9]{<$graphicsDir>bb.png} \hfill \includegraphics[scale=0.72]{<$graphicsDir>lds.png}}
\title{<$language.pdf.contract.addition_title> \\[0.5\baselineskip] <$contract.svnumber> \\[0.5\baselineskip] <$contract.name>}


% TODO: does not work yet (wrong page)
%\subtitle{<$contract.name>}

\date{\begin{normalsize}
<$language.pdf.common.createdOn>: <$contract.date_modified>
<if !empty($contract.deadline)>
\\ <$language.pdf.contract.deadline>: <$contract.deadline>
</if>
<if !empty($contract.startdate)>
\\ <$language.pdf.contract.startDate>: <$contract.startdate>
</if>
<if !empty($contract.enddate)>
\\ <$language.pdf.contract.endDate>: <$contract.enddate>
</if>
<if !empty($contract.periodofnotice)>
\\ <$language.pdf.contract.periodOfNotice>: <$contract.periodofnotice>
</if>
\end{normalsize}
}


\maketitle

\subsubsection*{<$language.pdf.common.customer>:}
\vspace{-0.5\baselineskip}
	<$contract.clientContact.account.name>\\
	<$contract.clientContact.account.billing_address_street>\\
	<$contract.clientContact.account.billing_address_postalcode>
	<$contract.clientContact.account.billing_address_city>
	
\subsubsection*{<$language.pdf.common.company>:}
\vspace{-0.5\baselineskip}
<$pdfCompanyAddress>
