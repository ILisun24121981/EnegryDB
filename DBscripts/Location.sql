SELECT locations.id, location_types.name As location_type, locations.name,locations.comment
FROM (
	locations INNER JOIN location_types ON locations.type_id = location_types.id
	)
WHERE locations.id = 2;