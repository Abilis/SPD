Таблицы БД:
1. users (id_user, login, password, id_role, name)
2. roles (id_role, name, description)
3. privs (id_privs, name, description)
4. privs2roles (id_role, id_priv)

5. sessions (id_session, id_user, sid, time_start, time_last)

6.spd_table (id_entry, numOrder, customer, tarif, ip_address, netmask,
			gateway, vlan_id, customer_port, termination_point, subnet,
			bloadcast, df_added, dt_last_adited, commentary, founder, last_editor)

7. logs (id_log, login, action, entry_old_log, entry_new_log, dt_action)

8. motd (id_motd, text, autor, dt_motd)

9. logs_action (id_log, login, message, dt_action)

10. addresses_of_nodes (id_node, ip_addresses, description, serial_number)