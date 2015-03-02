\documentclass[11pt,a4paper,german,parskip,headinclude,footexclude,DIV14]{scrartcl}
\usepackage[utf8]{inputenc}
\usepackage[ngerman]{babel}
\usepackage{longtable}
\usepackage{multirow}
\usepackage{booktabs}
\usepackage{scrpage2}
\usepackage{typearea}
\usepackage{graphicx}
\usepackage{eurosym}
\usepackage{pdflscape}
\usepackage{ifpdf}
\usepackage{helvet}
\usepackage{ifthen}
\usepackage{mdwlist}

% used for different international currency symbols like \textbaht or \textyen
\usepackage{textcomp}

\pagestyle{scrheadings}

\setlength\parindent{0in}

%\addtolength{\topmargin}{-0.4in}
%\addtolength{\textheight}{0.9in}

%\renewcommand{\familydefault}{cmss}
\renewcommand{\familydefault}{\sfdefault}


\begin{document}

%TODO: Kopfzeilenhöhe anpassen. Nichtkursiv. mit ohead alignen.
\ihead{\textnormal{Vertragsnummer AG: {{$contract.contractnumber}}\\
DMS Nummer: {{$contract.dmsnumber}}}}

\ohead{\textnormal{Erstellungsdatum: \today}}

\section*{ALLGEMEINE INFORMATION}

\begin{basedescript}{\desclabelwidth{12em}}
\item[Titel:] {{$contract.name}}
\item[Vertragsnummer AN:] {{$contract.contractnumberclient}}

\item[SV Nummer:] 
{{foreach item=svnumber from=$contract.svnumbers}}
	{{$svnumber.name}}\\
{{/foreach}}
\item[Kürzel:] {{$contract.abbreviation}}
\item[Kostenstelle:] {{$contract.kst}}
\item[Produktnummer:] {{$contract.productnumber}}

\item[Vertragstyp:] {{$contract.externalcontracttype}}
\item[Vertragsgegenstand:] {{$contract.externalcontractmatter}}
\end{basedescript}

{{if not empty($positions)}}
\begin{center}
        \begin{longtable}[t]{llrrp{0.57\textwidth}}
                Position & Art & Menge & Preis in {{$currencySymbol}} & Beschreibung \\
		\midrule
                \addlinespace
                \endfirsthead

                \addlinespace
%                \addlinespace
                Position & Art & Menge & Preis in {{$currencySymbol}} & Beschreibung \\
		\midrule
                \endhead

		{{foreach item=position from=$positions}}
			{{$position.name}} & {{$position.type}} & {{$position.quantity}} & {{$position.price}} & {{$position.description}} \\
		{{/foreach}}
	\end{longtable}
\end{center}
{{/if}}

\section*{KONTAKT INFORMATION}

\begin{basedescript}{\desclabelwidth{12em}}
\item[Firma AN:] {{$contract.account.name}}{{if !empty($contract.account.billing_address_street)}}\\{{/if}}
{{$contract.account.billing_address_street}}{{if !empty($contract.account.billing_address_postalcode)}}\\{{/if}}
{{$contract.account.billing_address_postalcode}} {{$contract.account.billing_address_city}}
\item[Kontakt AN:] {{$contract.clientcontactperson.name}}
\item[Kontakt AN Störung:] {{$contract.technicalcontactperson.name}}
\item[Kontakt AG:] {{$contract.contactperson.name}}
\vspace{\baselineskip}
\item[Lieferanschrift:] {{$contract.deliveryaddress}}
\item[Erfüllungsort:] {{$contract.completionaddress}}
\end{basedescript}

\section*{FRISTEN}
\begin{basedescript}{\desclabelwidth{12em}}
\item[Vertragsbeginn:] {{$contract.startdate}}
{{if $contract.endperiod == "other" || $contract.endperiod == $contract.enddate}}
	\item[Vertragsende:] {{$contract.enddate}}
{{else}}
	\item[Vertragsende:] {{$contract.enddate}} ({{$contract.endperiod}})
{{/if}}
\item[Kündigungsfrist:] {{$contract.cancellationperiod}}
\item[Mindestvertragsdauer:] {{$contract.minimumduration}}
\item[Gewährleistung:] {{if !empty($contract.warranteedeadline)}}{{$contract.warranteedeadline}} Monate{{/if}}
\item[Garantiefrist:] {{if !empty($contract.monthsguaranteed)}}{{$contract.monthsguaranteed}} Monate{{/if}}
\end{basedescript}

{{if not empty($costs)}}
	\section*{KOSTEN}
	
	Die Gesamtkosten des Vertrages über die gesamte Laufzeit {{$contract.startdate}} - {{$contract.enddate}} betragen {{if $contract.finalcosts}} {{$contract.finalcosts}} {{else}} 0,00 {{/if}} netto.

	\begin{landscape}	
	{{*
		initialize current category with category of first cost
		iterate over costs (assuming that costs are ordered by category, sorted by year)
		if the category has changed, start a new table listing the costs per year for this category
	*}} 
	{{assign var='currentCostCategory' value=$costs[0].category}}
	{{section name=i start=0 loop=$numberOfCosts step=1}}
		{{assign var='cost' value=$costs[$smarty.section.i.index]}}
	
		{{if 0 == $smarty.section.i.index}}
			{{* we are at the first row, start a new table *}}
			{{include file='include/oqc/Pdf/ExternalContract/TableHeader.tpl'}}
		{{elseif $cost.category != ''}} {{* a non-empty category fields signals that we enter a new category. with a category, the category fields are empty *}} 
			{{* end the previous (hopefully) opened table because we entered a new category *}}
			\end{longtable}
			\end{center}
			
			{{include file='include/oqc/Pdf/ExternalContract/TableHeader.tpl'}}
		{{/if}}
		
		{{* assume we are within a table now. just create new rows. *}}
		{{section name=k start=0 loop=$cost.numberOfDetailedCosts step=1}}
			{{assign var='detailedCost' value=$cost.detailedCosts[$smarty.section.k.index]}}
			
			\nopagebreak[4]
					
			{{if 0 == $smarty.section.k.index}}
				\multirow{{literal}}{{{/literal}}{{$cost.numberOfDetailedCosts}}{{literal}}}{{/literal}}{0.65\textheight}{{literal}}{{{/literal}}{{$cost.description}}{{literal}}}{{/literal}} &
			{{else}}
				&
			{{/if}}

			{{$detailedCost.price}} &
			{{$months[$detailedCost.month]}} &
			
			{{if 0 == $smarty.section.k.index}}
				\multirow{{literal}}{{{/literal}}{{$cost.numberOfDetailedCosts}}{{literal}}}{{/literal}}{0.05\textheight}{{literal}}{{{/literal}}{{$cost.year}}{{literal}}}{{/literal}}
			{{/if}}
			\\
		{{/section}}
		\hline
		\pagebreak[3]
	{{/section}}
	
	{{if $numberOfCosts == $smarty.section.i.index}}
		{{* we have just displayed the last cost. make sure we end the longtable properly.  *}}
		\end{longtable}
		\end{center}
	{{/if}}
		
	\end{landscape}
{{/if}}

\end{document}

