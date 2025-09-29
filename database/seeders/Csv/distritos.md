SELECT
o.v_numruc as ruc,
o.v_desrazon as nombre,
o.v_sigla as sigla,
o.v_direccion as direccion,
o.v_numtel as telefono,
o.v_email as email,
o.v_web as web,
d.ubigeo_dis as ubigeo,
o.i_codtiporg as categoria_id,
o.i_codnivel as nivel_id
FROM `cntbc_operador` as o
LEFT JOIN cntbc_distrito as d ON d.v_coddis = o.v_coddis and d.v_codpro = o.v_codpro and d.v_coddep = o.v_coddep
where CAST(o.v_coddis AS UNSIGNED) > 0;
