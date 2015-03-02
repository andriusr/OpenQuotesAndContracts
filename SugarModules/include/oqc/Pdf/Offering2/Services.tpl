\begin{landscape}

\begin{center}
\includegraphics[width=22.939cm,height=1.958cm]{<$graphicsDir>Offering2graphics.jpg}
\end{center}
\begin{center}
\tablefirsthead{}
\tablehead{}
\tabletail{}
\tablelasttail{}
\begin{supertabular}{m{0.666cm}m{5.7200003cm}m{4.46cm}m{1.7459999cm}m{2.5379999cm}m{1.479cm}m{1.204cm}m{2.3539999cm}m{0.925cm}|m{2.608cm}|}
\multicolumn{10}{m{25.500002cm}}{{\bfseries\itshape To: <$contract.clientContact.first_name> <$contract.clientContact.last_name> }}\\
\multicolumn{10}{m{25.500002cm}}{{\bfseries\itshape <$contract.clientContact.account.name>}}\\
\multicolumn{10}{m{25.500002cm}}{{\bfseries\itshape <$contract.clientContact.primary_address_country> }}\\
\multicolumn{10}{m{25.500002cm}}{\raggedleft{\bfseries\itshape Date: <$contract.date_modified>}}\\
\multicolumn{10}{m{25.500002cm}}{\centering{\bfseries\itshape QUOTE NO.: <$contract.svnumber>}}\\\hline
\multicolumn{1}{|m{0.666cm}|}{\centering{\bfseries NO}} &
\multicolumn{1}{m{5.7200003cm}|}{\centering{\bfseries ITEM}} &
\multicolumn{2}{m{6.406cm}|}{\centering{\bfseries DESCRIPTION}} &
\multicolumn{1}{m{2.5379999cm}|}{\centering{\bfseries PRICE, <$contract.currency_id>}} &
\multicolumn{1}{m{1.479cm}|}{\centering{\bfseries QTTY.}} &
\multicolumn{1}{m{1.204cm}|}{\centering{\bfseries UNIT}} &
\multicolumn{1}{m{2.3539999cm}|}{\centering{\bfseries DISCOUNT}} &
\centering{\bfseries VAT } &
\centering\arraybslash{\bfseries SUM, <$contract.currency_id>}\\\hline
<if is_array($oneTimeServices) && count($oneTimeServices) != 0>
<foreach item=service from=$oneTimeServices> 
\multicolumn{1}{|m{0.666cm}|}{\centering <$service.position>} &
\multicolumn{1}{m{5.7200003cm}|}{\centering <$service.name>} &
\multicolumn{2}{m{6.406cm}|}{\centering <$service.description>} &
\multicolumn{1}{m{2.5379999cm}|}{\centering  <$service.currency_symbol><sugar_currency_format var=$service.price round=true decimals=2 currency_symbol=false>} &
\multicolumn{1}{m{1.479cm}|}{\centering <$service.quantity>} &
\multicolumn{1}{m{1.204cm}|}{\centering <$service.unit>} &
\multicolumn{1}{m{2.3539999cm}|}{\centering {}-<if "rel" == $service.discount_select><$service.discount_value> \% <else> 
            <$service.currency_symbol><sugar_currency_format var=$service.discount_value round=true decimals=2 currency_symbol=false> </if>} &
\centering <$service.oqc_vat> \% &
\centering\arraybslash <$service.currency_symbol><sugar_currency_format var=$service.discounted_price*$service.quantity round=true decimals=2 currency_symbol=false>\\\hline
</foreach>
</if>

\multicolumn{9}{m{22.692001cm}|}{\raggedleft{\bfseries NET TOTAL, <$contract.currency_id>}} &
\centering\arraybslash  <$contract.currency_symbol><sugar_currency_format var=$ServicesOnceNetTotal round=true decimals=2 currency_symbol=false>\\\hhline{~~~~~~~~~-}
\multicolumn{9}{m{22.692001cm}|}{\raggedleft{\bfseries NET VAT TOTAL, <$contract.currency_id>}} &
\centering\arraybslash <$contract.currency_symbol><sugar_currency_format var=$ServicesOnceVAT|string_format:"%.2f" round=true decimals=2 currency_symbol=false>\\\hhline{~~~~~~~~~-}
\multicolumn{9}{m{22.692001cm}|}{\raggedleft{\bfseries GRAND TOTAL, <$contract.currency_id>}} &
\centering\arraybslash <$contract.currency_symbol><sugar_currency_format var=$ServicesOnceGrossTotal round=true decimals=2 currency_symbol=false>\\\hhline{~~~~~~~~~-}
\multicolumn{3}{m{11.246cm}}{{\bfseries\itshape TERMS AND CONDITIONS:}} &
\multicolumn{6}{m{11.246cm}}{Signed: } &
\multicolumn{1}{m{2.608cm}}{~
}\\
\multicolumn{3}{m{11.246cm}}{{\bfseries Shipment terms: \textmd{<$contract.shipment_terms>.}}} &
\multicolumn{6}{m{11.246cm}}{<$contract.userContact.first_name> <$contract.userContact.last_name>} &
\multicolumn{1}{m{2.608cm}}{~
}\\
\multicolumn{3}{m{11.246cm}}{{\bfseries Warranty: \textmd{<$contract.warranty>.}}} &
\multicolumn{6}{m{11.246cm}}{<$contract.userContact.title>} &
\multicolumn{1}{m{2.608cm}}{~
}\\
\multicolumn{3}{m{11.246cm}}{{\bfseries Delivery: \textmd{<$contract.quote_leadtime>.}}} &
\multicolumn{6}{m{11.246cm}}{{\itshape This is electronic message send by email}} &
\multicolumn{1}{m{2.608cm}}{~
}\\
\multicolumn{9}{m{22.692001cm}}{{\bfseries Payment: \textmd{<$contract.payment_terms>.}}} &
\multicolumn{1}{m{2.608cm}}{~
}\\
\multicolumn{9}{m{22.692001cm}}{{\bfseries Quote is valid: \textmd{<$contract.quote_validity>.}}} &
\multicolumn{1}{m{2.608cm}}{~
}\\
\end{supertabular}
\end{center}

\bigskip
\end{landscape}

%removed pictures after services table

