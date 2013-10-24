ALTER TABLE tb_processo 
add column pessoa_cadastro_id int(11),
add constraint fk_pessoa_cadastro foreign key (pessoa_cadastro_id) references tb_pessoa (id_pessoa);