var OqcProductsPackages = function() {
    return {
        initPackagesTable: function(containerId, productId) {
            YAHOO.util.Event.addListener(window, "load", function() {
                var name = {
                    key:"Name",
                    label: languageStrings.name, // this assumes that the translation labels have been loaded already
                    formatter: function(elCell, oRecord, oColumn, oData) { // "text",
                        elCell.innerHTML = OqcCommon.getBeanLink('oqc_Product', oRecord.getData('Name'), oRecord.getData('Id'));
                    }
                };
              
                var myColumnDefs = [name];
                
                // TODO evaluate security (xss, access control)
                var myDataSource = new YAHOO.util.DataSource("oqc/GetPackagesForService.php?id="+productId);

                // JSON
                myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
                myDataSource.connXhrMode = "queueRequests";

                myDataSource.responseSchema = {
                    // ResultNode: "ResultSet", // for XML
                    resultsList: "ResultSet", // for JSON
                    fields: ["Name", "Id"]
                };

                var myDataTable = new YAHOO.widget.DataTable(
                    containerId,
                    myColumnDefs,
                    myDataSource,
                    {
                    	MSG_EMPTY : oqcYUIMessages.LBL_NO_RECORDS_MESSAGE,
                    	MSG_ERROR : oqcYUIMessages.LBL_DATA_ERROR_MESSAGE,
                    	MSG_LOADING : oqcYUIMessages.LBL_LOADING_MESSAGE
                    	}
                );
            });
        }
    };
}();
