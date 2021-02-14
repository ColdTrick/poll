<?php

return array (
  'item:object:poll' => 'Sondage',
  'collection:object:poll' => 'Sondages',
  'river:object:poll:create' => '%s a créé le sondage %s',
  'river:object:poll:vote' => '%s a participé sondage %s',
  'river:object:poll:comment' => '%s a posté un commentaire sous le sondage %s',
  'poll:settings:enable_site' => 'Activer les sondages sur le site',
  'poll:settings:enable_site:info' => 'Les utilisateurs sont-ils autorisés à créer des sondages ?',
  'poll:settings:enable_group' => 'Activer les sondages pour les groupes',
  'poll:settings:enable_group:info' => 'Les utilisateurs sont-ils autorisés à créer des sondages dans les groupes ? Les groupes doivent activer cette fonction s\'ils souhaitent l\'utiliser.',
  'poll:settings:group_create' => 'Par défaut, qui peut créer des sondages dans un groupe ?',
  'poll:settings:group_create:info' => 'Lorsque vous activez les sondages pour les groupes, ce paramètre contrôlera qui peut créer les sondages par défaut. Les fondateur de groupes peuvent configurer autrement.',
  'poll:settings:group_create:options:members' => 'Les membres du groupe',
  'poll:settings:group_create:options:owners' => 'Les administrateurs du groupe',
  'poll:settings:close_date_required' => 'Date de clôture requise ?',
  'poll:settings:close_date_required:info' => 'Par défaut, une date de clôture n\'est pas requise pour un sondage. Ce paramètre la rendra obligatoire.',
  'poll:settings:vote_change_allowed' => 'Est-il permis de changer son vote ?',
  'poll:settings:vote_change_allowed:info' => 'Ces paramètres permettent aux utilisateurs de modifier leur vote après avoir participé une première fois.',
  'poll:settings:add_vote_to_river' => 'Ajouter une entrée sur le flux d\'activité quand il y a une participation à un sondage',
  'poll:settings:add_vote_to_river:info' => 'Ce paramètre détermine si le vote sur un sondage est ajouté au flux d\'activité.',
  'poll:none' => 'Aucun sondage n\'a été trouvé',
  'poll:group' => 'Sondages du groupe',
  'poll:add' => 'Ajouter un nouveau sondage',
  'poll:all:title' => 'Tous les sondages du site',
  'poll:edit:answers' => 'Réponses',
  'poll:owner:title' => 'Sondages de %s',
  'poll:friends:title' => 'Sondages des contacts',
  'poll:edit:title' => 'Modifier le sondage "%s"',
  'poll:edit:answers:name' => 'Nom',
  'poll:edit:answers:label' => 'Label',
  'poll:edit:answers:show_internal_names' => 'Afficher les noms internes',
  'poll:edit:close_date' => 'Date de clôture',
  'poll:edit:results_output' => 'Voir les résultats en',
  'poll:edit:results_output:pie' => 'graphique circulaire',
  'poll:edit:results_output:bar' => 'diagramme à barres',
  'poll:edit:error:cant_edit' => 'Vous n\'êtes pas autorisé à modifier ce sondage',
  'poll:edit:error:answer_count' => 'Vous devez avoir au moins deux réponses lorsque vous créez un sondage',
  'poll:closed' => 'Ce sondage est clos depuis :',
  'poll:closed:future' => 'Clôture du sondage :',
  'poll:no_votes' => 'Aucun vote n\'a été effectué',
  'poll:vote:title' => 'Participer à ce sondage',
  'poll:menu:site' => 'Sondages',
  'poll:menu:owner_block:group' => 'Sondages du groupe',
  'poll:vote' => 'Participer',
  'poll:menu:poll_tabs:vote' => 'Participation',
  'poll:menu:poll_tabs:results' => 'Résultats',
  'poll:group_tool:title' => 'Activer les sondages pour le groupe',
  'poll:group_settings:title' => 'Paramètres des sondages pour les membres du groupe',
  'poll:group_settings:members' => 'Permettre aux membres du groupe de créer des sondages',
  'poll:group_settings:members:description' => 'Lorsque ce paramètre est réglé sur "non", seuls les administrateurs peuvent créer des sondages dans ce groupe.',
  'widgets:single_poll:name' => 'Sondage mis en avant',
  'widgets:single_poll:description' => 'Afficher un seul sondage',
  'poll:widgets:single_poll:poll_guid:object' => 'Entrez le titre du sondage et sélectionnez dans la liste',
  'widgets:recent_polls:name' => 'Sondages récents',
  'widgets:recent_polls:description' => 'Afficher une liste des sondages récemment créés',
  'poll:container_gatekeeper:user' => 'La fonction sondage n\'est pas activé pour un usage personnel',
  'poll:container_gatekeeper:group' => 'La fonction sondage n\'est pas activé pour une utilisation dans les groupes',
  'poll:notification:create:subject' => 'Le nouveau sondage "%s" a été créé',
  'poll:notification:create:summary' => 'Nouveau sondage "%"',
  'poll:notification:create:body' => 'Bonjour,

%s a créé un nouveau sondage "%s".

%s

Pour consulter le sondage, cliquez sur le lien :
%s',
  'poll:notification:close:owner:subject' => 'Votre sondage "%s" est maintenant clos',
  'poll:notification:close:owner:summary' => 'Votre sondage "%s" est maintenant clos',
  'poll:notification:close:owner:body' => 'Bonjour %s,

Votre sondage "%s" est maintenant clos. Les utilisateurs ne peuvent plus participer.

Pour voir les résultats, consultez le sondage ici :
%s',
  'poll:notification:close:participant:subject' => 'Le sondage "%s" auquel vous avez participé est clos',
  'poll:notification:close:participant:summary' => 'Le sondage "%s" auquel vous avez participé est clos',
  'poll:notification:close:participant:body' => 'Salut,

Le sondage "%s" auquel vous avez participé est maintenant clos.

Pour voir les résultats, consultez le sondage ici :
%s',
  'poll:action:edit:error:title' => 'Veuillez donner un titre',
  'poll:action:vote:error:input' => 'Vous devez choisir une réponse',
  'poll:action:vote:error:can_vote' => 'Vous n\'êtes pas autorisé à participer à ce sondage',
  'poll:action:vote:error:vote' => 'Une erreur s\'est produite lors de la sauvegarde de votre participation',
  'poll:action:vote:success' => 'Votre participation a été enregistrée',
  'poll:action:export:error:no_votes' => 'Pas de vote exportable',
);
