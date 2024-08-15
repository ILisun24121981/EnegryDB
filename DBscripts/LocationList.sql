SELECT location_structure.child_id, location_types.name As location_type, locations.name,locations.comment
FROM (
	(location_structure INNER JOIN locations ON location_structure.child_id = locations.id)
	INNER JOIN location_types ON locations.type_id = location_types.id
    )
WHERE location_structure.parent_id = 2;