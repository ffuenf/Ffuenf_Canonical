-- add table prefix if you have one
DELETE FROM core_config_data WHERE path like 'ffuenf_canonical/%';
DELETE FROM core_config_data WHERE path like 'advanced/modules_disable_output/Ffuenf_Canonical';
DELETE FROM core_resource WHERE code = 'ffuenf_canonical_setup';
DELETE FROM eav_attribute WHERE attribute_code = 'ffuenf_canonicalurl'