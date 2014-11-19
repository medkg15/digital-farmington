define(['underscore'], function (_) {

    return function (allYears, step) {

        // determines which of the map years is closest to the given year
        var closestYearWithMap = function (year) {
            var distances = _.map(allYears, function (mapYear) {
                return {year: mapYear, distance: Math.abs(mapYear - year)};
            });

            var smallest = distances[0];

            for (var i = 1; i < distances.length; i++) {
                if (smallest.distance > distances[i].distance) {
                    smallest = distances[i];
                }
            }

            return smallest.year;
        };

        // pre-compute where we will "jump to" for years that we don't have maps
        var roundTo = [];

        for (var year = allYears[0]; year <= allYears[allYears.length - 1]; year += step) {
            // this could be optimized so we only look at the previous and next years
            roundTo[year] = closestYearWithMap(year);
        }

        return roundTo;
    };
});