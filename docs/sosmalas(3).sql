
/*CRIACAO DE TABELA STATUS_PROCESSO*/

create table tb_status_processo(
	id_status int(11) not null primary key auto_increment,
	tx_status varchar(50)
);
-- drop table tb_status_processo;

/*INSERT DADOS EM STATUS PROCESSO*/
insert into tb_status_processo values 
(1, 'Em concerto'),
(2, 'Aguardando peça'),
(3, 'Reprovada p/ concerto'),
(4, 'Em trânsito'),
(5, 'Finalizado');

/*CRIACAO DE TABELA PROCESSO*/
create table tb_processo(
	id_processo int(11) not null primary key auto_increment comment 'Chave primaria',
	cod_processo varchar(20) comment 'Codigo do processo ex: AAA332',
	id_empresa int(11) comment 'Referencia a tabela pessoa',
	nome_cliente varchar(100) comment 'Nome do cliente dono da mala',
	quantidade int(11) comment 'Quantidade de malas',
	descricao_produto varchar(255) comment 'Contem a descrição do produto como nome, marca, modelo e cor',
	conserto varchar(255) comment 'Contem a descrição do conserto efetuado',
	dt_coleta date comment 'Data da coleta',
	dt_entrega date comment 'Data da entrega',
	status_id int(1) comment 'Chave estrangeira de tb_status_processo',
constraint pessoa_fk foreign key (id_empresa) references pessoa (id_pessoa) 
on update no action on delete no action,
constraint status_processo_fk foreign key (status_id) references tb_status_processo (id_status)
on update no action on delete no action
);
-- drop table tb_processo;

/*CARGA DE DADOS DE TABELA ANTERIOR*/
INSERT INTO tb_processo(
id_processo, cod_processo, id_empresa, nome_cliente, quantidade, 
descricao_produto, conserto, dt_coleta, dt_entrega, status_id) 
SELECT id_processo, os_processo, pessoa_entrada, nome_pax_processo, qtd_bagagem_processo, 
NULL, servico_realizado_processo, data_coleta_processo, data_entrega_processo, 1
FROM processos;

select * from tb_processo;