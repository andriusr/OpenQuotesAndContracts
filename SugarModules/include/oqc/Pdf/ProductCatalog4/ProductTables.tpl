\newpage
\chapter{\textbf{<$language.pdf.catalog.prices>}}

<if isset($rootCategories) && not empty($rootCategories)>
<foreach from=$rootCategories item=category>

		\begin{center}
		\begin{longtable}[t]{lp{0.55\textwidth}lr}
			\toprule
			\addlinespace
			<$language.pdf.catalog.position> &
          <$language.pdf.catalog.services> &
          <$language.pdf.catalog.unit> &
          <$language.pdf.catalog.price> in <$currency.currency_id>\setcounter{oqc_pn}{1} \\
			\addlinespace
			\midrule
			\endhead

			\bottomrule
			\endfoot
			
			<include file="include/oqc/Pdf/ProductCatalog4/Products.tpl" rootCategories=$category>
						
		\end{longtable}
		\end{center}

	
</foreach>
</if>
