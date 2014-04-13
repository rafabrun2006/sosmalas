
/*Criando novas tabelas necessarias*/
create table tb_local_entrega_coleta (
	id_local_entrega_coleta int primary key auto_increment,
	tx_local varchar(50)
);

create table tb_forma_faturamento (
	id_forma_faturamento int primary key auto_increment,
	tx_forma_faturamento varchar(50)
);

/*Inserindo valores padroes*/
insert into tb_forma_faturamento (tx_forma_faturamento)
values ('Garantia'), ('Particular'), ('Faturado');

insert into tb_local_entrega_coleta (tx_local) 
values 
('Aeroporto'), ('Residência'), ('Oficina');

/*Adicionando novos campos que servirao de chaves estrangeiras*/
alter table tb_processo add column valor double(8,2) null default 0;
alter table tb_processo add column forma_faturamento_id int default 3;

/*Alterando tabela para adicao de contraints*/
alter table tb_processo
add column local_entrega_id int,
add column local_coleta_id int,
add constraint fk_local_entrega foreign key(local_entrega_id) references tb_local_entrega_coleta(id_local_entrega_coleta),
add constraint fk_local_coleta foreign key(local_coleta_id) references tb_local_entrega_coleta(id_local_entrega_coleta),
add constraint fk_forma_faturamento foreign key(forma_faturamento_id) references tb_forma_faturamento(id_forma_faturamento);
