<* TODO numbering of figures only works properly if labels is at the bottom of the figure. *>
<* TODO if labels is above \includegraphics or \fitpic the references to the figures all look like "1.1" instead of "figure 1" and "figure 2" *>
<if $service.has_image>
\begin{figure}
    \centering
    \fitpic{<$service.image_url>}
    \caption{<$service.name>}
    \label{productImage<$service.id|replace:"-":"">}
\end{figure}
</if>
