\begin{landscape}
\section*{<$language.pdf.contract.titleServices>}

<if is_array($oneTimeServices) && count($oneTimeServices) != 0>
	\subsection*{<$language.Services.onceTableTitle>}
		\begin{center}
		\begin{longtable}[t]{p{0.24\textwidth}rllrrp{0.4\textwidth}}
			\toprule                 
				\textbf{<$language.Services.name>} &
            \textbf{<$language.Services.unit>} &
				\textbf{<$language.Services.quantity>} & 
				\textbf{<$language.Services.discountPrice>,<$contract.currency_id>} &
				\textbf{<$language.Services.vat>} &
				\textbf{<$language.Services.sum>,<$contract.currency_id>} &
				\textbf{<$language.Services.description>} \\
			\midrule
			\endhead

			\midrule
			\endfoot

			\midrule
			\nopagebreak
			\addlinespace
%			\pagebreak[3]
			\nopagebreak
			\multicolumn{5}{r}{} & \multicolumn{2}{l}{\textbf{<$language.Services.sum>,<$contract.currency_id>}}\\
			\nopagebreak
			\cmidrule{5-7}
			\nopagebreak
			\multicolumn{5}{r}{\textbf{<$language.Services.net>:}} & <$contract.currency_symbol><sugar_currency_format var=$ServicesOnceNetTotal round=true decimals=2 currency_symbol=false> \\
			\nopagebreak
			\multicolumn{5}{r}{\textbf{<$language.Services.vat>:}} & <$contract.currency_symbol><sugar_currency_format var=$ServicesOnceVAT|string_format:"%.2f" round=true currency_symbol=false decimals=2|default:0.00> \\
			\nopagebreak
			\multicolumn{5}{r}{\textbf{<$language.Services.gross>:}} & <$contract.currency_symbol><sugar_currency_format var=$ServicesOnceGrossTotal round=true decimals=2 currency_symbol=false> \\
     		\nopagebreak
			\bottomrule
			\endlastfoot

			<foreach item=service from=$oneTimeServices> 
				<$service.name> &
            <$service.unit> &
				<$service.quantity> &
				<if $service.discount_value != 0>
              <$service.currency_symbol><sugar_currency_format var=$service.price round=true decimals=2 currency_symbol=false> - <if "rel" == $service.discount_select> <$service.discount_value>\%
             <else> 
            <$service.currency_symbol><sugar_currency_format var=$service.discount_value round=true decimals=2 currency_symbol=false> </if> = <$service.currency_symbol><sugar_currency_format var=$service.discounted_price_tax_free round=2 decimals=2 currency_symbol=false> &
				<else>
					 <$service.currency_symbol><sugar_currency_format var=$service.price currency_symbol=false> &		
				</if> 
				$<$service.oqc_vat> \%$ &                          
            <$service.currency_symbol><sugar_currency_format var=$service.discounted_price*$service.quantity round=true decimals=2 currency_symbol=false> &
            <$service.description> <if $service.has_image> (<$language.pdf.common.seeFigure> \ref{productImage<$service.id|replace:"-":"">} <$language.pdf.common.onPage> \pageref{productImage<$service.id|replace:"-":"">}) </if> \\
			</foreach>
		\end{longtable}
		\end{center}
</if>

<if is_array($services) && count($services) != 0>
	\newpage
	\subsection*{<$language.Services.ongoingTableTitle>}
		\begin{center}
		\begin{longtable}[t]{p{0.2\textwidth}rrrrrlp{0.4\textwidth}}
			\toprule
            \textbf{<$language.Services.name>} &
            \textbf{<$language.Services.unit>} &
				\textbf{<$language.Services.quantity>} &
				\textbf{<$language.Services.discountPrice>,<$contract.currency_id>} &
				\textbf{<$language.Services.vat>} &
				\textbf{<$language.Services.sum>,<$contract.currency_id>} &
				\textbf{<$language.Services.zeitbezug>} &
				\textbf{<$language.Services.description>} \\			
			\midrule
			\endhead

			\midrule
			\endfoot

			\midrule
			\nopagebreak
			\addlinespace
%			\pagebreak[3]
			\nopagebreak
			\multicolumn{5}{r}{} & \multicolumn{3}{l}{\textbf{
					<$language.Services.sum> 
					<$language.common.in> <$contract.currency_symbol>
					<$language.common.for>
					<if !empty($contract.startdate) && !empty($contract.enddate)>
						<$contract.startdate> <$language.common.until> <$contract.enddate>, </if>
					<$OngoingMonths> <$language.common.months> }}\\
			\nopagebreak
			\cmidrule{5-8}
			\nopagebreak
			\multicolumn{5}{r}{\textbf{<$language.Services.net>:}} & <$contract.currency_symbol><sugar_currency_format var=$OngoingCostsNetTotal round=true decimals=2 currency_symbol=false> \\
			\nopagebreak
			\multicolumn{5}{r}{\textbf{<$language.Services.vat>:}} & <$contract.currency_symbol><sugar_currency_format var=$OngoingCostsVAT|string_format:"%.2f" round=true decimals=2 currency_symbol=false> \\
			\nopagebreak
			\multicolumn{5}{r}{\textbf{<$language.Services.gross>:}} & <$contract.currency_symbol><sugar_currency_format var=$OngoingCostsGrossTotal round=true decimals=2 currency_symbol=false> \\
			\nopagebreak
			\bottomrule
			\endlastfoot

			<foreach item=service from=$services>
            <$service.name> &
            <$service.unit> &
				<$service.quantity> &
				<if $service.discount_value != 0>
                	<$service.currency_symbol><sugar_currency_format var=$service.price round=true decimals=2 currency_symbol=false> - <if "rel" == $service.discount_select> <$service.discount_value>\% <else> <$service.currency_symbol><sugar_currency_format var=$service.discount_value round=true decimals=2 currency_symbol=false> </if> = <$service.currency_symbol><sugar_currency_format var=$service.discounted_price_tax_free round=true decimals=2 currency_symbol=false> &
				<else>
					<$service.currency_symbol><sugar_currency_format var=$service.price round=true decimals=2 currency_symbol=false> &		
				</if>
				   $<$service.oqc_vat> \%$ &                            
                <$service.currency_symbol><sugar_currency_format var=$service.discounted_price*$service.quantity round=true decimals=2 currency_symbol=false> &
				<$service.zeitbezug> &
				<$service.description> <if $service.has_image> (<$language.pdf.common.seeFigure> \ref{productImage<$service.id|replace:"-":"">} <$language.pdf.common.onPage> \pageref{productImage<$service.id|replace:"-":"">}) </if> \\
			</foreach>
			
		\end{longtable}
		\end{center}
</if>
\end{landscape}

<* NOTE: when have to insert product images template here because otherwise the images_exist value is not available. it is inserted in servicesToLatex (oqc_createpdf.php). the key is only available in this template. *>
<include file="include/oqc/Pdf/Addition/ProductImages.tpl">

