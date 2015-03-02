var OqcCalendar = function() {
	return {
		getMonthsBetween: function(date1, date2) {
			var months = 0;
		
			date1 = getDateObject(date1); // aus sugar_3.js, liefert true bei Leerstring, false bei falschem String oder ein Date-Objekt bei passendem String    
			date2 = getDateObject(date2);
		
			if ((typeof(date1) != 'object') || (typeof(date2) != 'object'))
				return 12; // 12 Monate als Default
		
			// Sicherstellen, dass date1 vor date2 liegt
			if (date1 > date2)
			{
				datebackup = date1;
				date1 = date2;
				date2 = datebackup;
			}
		
			months += (date2.getFullYear() - date1.getFullYear() - 1) * 12;
			months += (12 - (date1.getMonth() + 1)); 
			months += (date2.getMonth() + 1);
			months += 1;
		
			// TODO macht das sinn?
			if (months < 1)
				months = 1;
		
			return months;	
		},
		
		getEarlierDate: function(dateField1, dateField2) {
			var date1 = document.getElementById(dateField1);
			var date2 = document.getElementById(dateField2);
		
			date1 = getDateObject(date1.value); // aus sugar_3.js, liefert true bei Leerstring, false bei falschem String oder ein Date-Objekt bei passendem String    
			date2 = getDateObject(date2.value);
		
			// TODO return current year as default
			if ((typeof(date1) != 'object') || (typeof(date2) != 'object')) {
				return false;
			}
			
			if (date1 > date2) {
				datebackup = date1;
				date1 = date2;
				date2 = datebackup;
			}
			
			return date1;
		},
		
		getStartYear: function(dateField1, dateField2) {
			var startDate = OqcCalendar.getEarlierDate(dateField1, dateField2);
			
			if (startDate) {
				return startDate.getFullYear();
			} else {
				// TODO return current year as default
				return 2009;
			}
		}
	};
}();