 # SCÉNARIO DE TEST COMPLET - APPLICATION SCHOOL MANAGEMENT

## PHASE 0: PRÉPARATION
✅ Arrêter le serveur précédent
✅ Lancer: `php artisan serve`
✅ Se connecter sur http://localhost:8000

--- 

## PHASE 1: CONFIGURATION INITIALE (ADMIN)

### 1.1 - Créer une Année Scolaire
**Route:** Admin > Années Scolaires
1. Cliquer sur "Nouvelle Année"
2. Remplir:
   - Libellé: `2025-2026`
   - Date Début: `01/10/2025`
   - Date Fin: `30/07/2026`
   - Statut: `À venir`
3. Cliquer "Créer l'année"
✅ Message: "Année scolaire créée avec succès"

### 1.2 - Créer une 2ème Année et l'Activer
**Route:** Admin > Années Scolaires
1. Cliquer sur "Nouvelle Année"
2. Remplir:
   - Libellé: `2024-2025`
   - Date Début: `01/10/2024`
   - Date Fin: `30/07/2025`
   - Statut: `En cours`
3. Cliquer "Créer l'année"
4. Sur la liste, cliquer le bouton ✓ (Activer) sur l'année `2024-2025`
✅ Message: "Année 2024-2025 activée avec succès"

### 1.3 - Créer les Classes
**Route:** Admin > Classes
1. Cliquer "Nouvelle Classe"
2. Créer 3 classes:
   - **Classe 1:** Nom=`Seconde A`, Niveau=`Seconde`, Frais Scolarité=`100000`
   - **Classe 2:** Nom=`Seconde B`, Niveau=`Seconde`, Frais Scolarité=`100000`
   - **Classe 3:** Nom=`Première C`, Niveau=`Première`, Frais Scolarité=`120000`
✅ Chaque: "Classe créée avec succès"

### 1.4 - Créer les Matières
**Route:** Admin > Cours (pour voir les matieres => impliqué dans les cours)
Ou via le contrôleur Matière si disponible
1. Créer 4 matières:
   - `Mathématiques`
   - `Français`
   - `Anglais`
   - `Sciences Physiques`

### 1.5 - Créer les Cours
**Route:** Admin > Cours
1. Cliquer "Nouveau Cours"
2. Créer 3 cours:
   - **Cours 1:** Matière=`Mathématiques`, Classe=`Seconde A`, Année=`2024-2025`
   - **Cours 2:** Matière=`Français`, Classe=`Seconde A`, Année=`2024-2025`
   - **Cours 3:** Matière=`Anglais`, Classe=`Seconde B`, Année=`2024-2025`
✅ "Cours créé avec succès"

### 1.6 - Créer les Enseignants
**Route:** Admin > Enseignants
1. Cliquer "Nouvel Enseignant"
2. Créer 3 enseignants:
   - **Prof 1:** Nom=`DUPONT`, Prénom=`Jean`, Email=`jean.dupont@school.cg`, Spécialité=`Mathématiques`, Téléphone=`0612345678`
   - **Prof 2:** Nom=`MARTIN`, Prénom=`Sophie`, Email=`sophie.martin@school.cg`, Spécialité=`Français`, Téléphone=`0687654321`
   - **Prof 3:** Nom=`BERNARD`, Prénom=`Marc`, Email=`marc.bernard@school.cg`, Spécialité=`Anglais`, Téléphone=`0698765432`
3. **Cocher:** "Créer un compte utilisateur" pour chaque
✅ "Enseignant créé avec succès" + compte user créé

### 1.7 - Créer les Étudiants
**Route:** Admin > Étudiants
1. Cliquer "Nouvel Étudiant"
2. Créer 5 étudiants:
   - **Élève 1:** Matricule=`2024001`, Nom=`JOHNSON`, Prénom=`Alice`, Date Naissance=`15/06/2008`, Sexe=`F`, Email=`alice.johnson@eleve.school.cg`, ☑ Créer compte
   - **Élève 2:** Matricule=`2024002`, Nom=`WILLIAMS`, Prénom=`Bob`, Date Naissance=`22/03/2008`, Sexe=`M`, Email=`bob.williams@eleve.school.cg`, ☑ Créer compte
   - **Élève 3:** Matricule=`2024003`, Nom=`BROWN`, Prénom=`Carla`, Date Naissance=`10/11/2008`, Sexe=`F`, Email=`carla.brown@eleve.school.cg`, ☑ Créer compte
   - **Élève 4:** Matricule=`2024004`, Nom=`DAVIS`, Prénom=`David`, Date Naissance=`05/07/2009`, Sexe=`M`, Email=`david.davis@eleve.school.cg`, ☑ Créer compte
   - **Élève 5:** Matricule=`2024005`, Nom=`MILLER`, Prénom=`Emma`, Date Naissance=`28/04/2008`, Sexe=`F`, Email=`emma.miller@eleve.school.cg`, ☑ Créer compte
✅ "Étudiant créé avec succès"

### 1.8 - Inscrire les Étudiants (pour l'année active 2024-2025)
**Route:** Admin > Inscriptions
1. Cliquer "Nouvelle Inscription"
2. Créer 5 inscriptions:
   - **Inscription 1:** Étudiant=`JOHNSON Alice`, Classe=`Seconde A`, Type=`Nouvelle`, Paiement=`En attente`
   - **Inscription 2:** Étudiant=`WILLIAMS Bob`, Classe=`Seconde A`, Type=`Nouvelle`, Paiement=`Partiel`
   - **Inscription 3:** Étudiant=`BROWN Carla`, Classe=`Seconde B`, Type=`Nouvelle`, Paiement=`En attente`
   - **Inscription 4:** Étudiant=`DAVIS David`, Classe=`Seconde B`, Type=`Nouvelle`, Paiement=`Réglé`
   - **Inscription 5:** Étudiant=`MILLER Emma`, Classe=`Seconde A`, Type=`Nouvelle`, Paiement=`En attente`
✅ "Inscription créée avec succès"

---

## PHASE 2: ACTIVITÉS PROFESSEUR

Compte pour tester: 
- Email: `jean.dupont@school.cg` 
- Password: `password`

### 2.1 - Se Connecter en tant que Professeur
1. Se déconnecter (Admin)
2. Se connecter avec `jean.dupont@school.cg` / `password`
✅ Page: "Tableau de Bord Professeur"

### 2.2 - Consulter Mes Cours
**Route:** Prof > Mes Cours
1. Consulter la liste des cours assignés
✅ Voir: Mathématiques - Seconde A

### 2.3 - Ajouter des Notes
**Route:** Prof > Notes
1. Cliquer "Ajouter des Notes"
2. Sélectionner:
   - Cours: `Mathématiques - Seconde A`
   - Type d'Examen: `Devoir` (ou créer)
3. Ajouter notes pour 3 étudiants:
   - JOHNSON Alice: 18/20
   - WILLIAMS Bob: 15/20
   - MILLER Emma: 16/20
4. Cliquer "Enregistrer les notes"
✅ "Notes créées avec succès" + Notifications envoyées aux étudiants

### 2.4 - Vérifier les Notifications Reçues (Admin)
1. Se déconnecter
2. Se connecter comme Admin
3. Aller sur: Notifications (icône 🔔 en haut)
✅ Voir notifications: "Nouvelle note disponible en Mathématiques: 18/20"

### 2.5 - Créer un Devoir
**Route:** Prof > Devoirs
1. Cliquer "Nouveau Devoir"
2. Remplir:
   - Cours: `Mathématiques - Seconde A`
   - Titre: `Exercices sur les équations`
   - Description: `Résoudre les 10 équations du chapitre 3`
   - Date Limite: `20/02/2026`
3. Cliquer "Créer le devoir"
✅ "Devoir créé avec succès" + Admin reçoit notification

### 2.6 - Créer un Examen
**Route:** Prof > Examens
1. Cliquer "Nouveau Examen"
2. Remplir:
   - Cours: `Mathématiques - Seconde A`
   - Titre: `Examen de contrôle`
   - Date: `15/03/2026`
   - Durée: `2 heures`
3. Clicker "Créer l'examen"
✅ "Examen créé avec succès" + Admin notifié

### 2.7 - Télécharger une Ressource Pédagogique
**Route:** Prof > Ressources
1. Cliquer "Ajouter une Ressource"
2. Remplir:
   - Cours: `Mathématiques - Seconde A`
   - Titre: `Chapitre 3 - Équations`
   - Description: `Cours complet sur les équations du premier degré`
   - Fichier: (Charger un PDF ou TXT)
3. Cliquer "Télécharger"
✅ "Ressource créée avec succès" + Admin notifié

### 2.8 - Voir l'Emploi du Temps
**Route:** Prof > Emploi du Temps
✅ Affiche la grille d'emploi du temps

---

## PHASE 3: ACTIVITÉS ÉTUDIANT (Connexion et Suivi)

Compte pour tester:
- Email: `alice.johnson@eleve.school.cg`
- Password: `password`

### 3.1 - Se Connecter en tant qu'Étudiant
1. Se déconnecter (Admin)
2. Se connecter avec `alice.johnson@eleve.school.cg` / `password`
✅ Redirect vers "Sélection Année" (car aucune année sélectionnée)

### 3.2 - Sélectionner l'Année Scolaire
**Route:** Eleve > Sélection Année
1. Voir: "2024-2025 (En cours)" ✓
2. Cliquer sur "Valider"
✅ Redirect vers Dashboard

### 3.3 - Consulter le Dashboard
**Route:** Eleve > Dashboard
✅ Voir les statistiques:
- Moyenne générale: 18/20 (si note ajoutée à Phase 2.3)
- Total notes: 1
- Frais scolarité: 100 000 FCFA
- Montant payé: 0 FCFA
- Reste à payer: 100 000 FCFA

### 3.4 - Consulter Mes Notes
**Route:** Eleve > Mes Notes
✅ Voir:
- Cours: Mathématiques
- Note: 18/20
- Date: (date actuelle)
- Type: Devoir

### 3.5 - Télécharger les Ressources Pédagogiques
**Route:** Eleve > Ressources
1. Voir la ressource créée par le prof: "Chapitre 3 - Équations"
2. Cliquer sur le bouton "Télécharger" (ou icône)
✅ Le fichier se télécharge

### 3.6 - Consulter Mes Devoirs
**Route:** Eleve > Devoirs
✅ Voir le devoir créé:
- Titre: `Exercices sur les équations`
- Dates limite: `20/02/2026`
- Statut: `Non rendu`

### 3.7 - Consulter Mes Examens
**Route:** Eleve > Examens
✅ Voir l'examen créé:
- Titre: `Examen de contrôle`
- Date: `15/03/2026`
- Durée: `2 heures`

### 3.8 - Consulter Emploi du Temps
**Route:** Eleve > Emploi du Temps
✅ Affiche la grille d'emploi du temps pour Seconde A

### 3.9 - Voir les Absences
**Route:** Eleve > Absences
✅ Affiche les absences (actuellement: aucune)

### 3.10 - Consulter les Notifications
**Route:** Icône 🔔 en haut
✅ Voir:
- "Nouvelle note disponible en Mathématiques: 18/20"
- "Nouveau devoir créé" (si notif prof)
- "Nouvel examen créé" (si notif prof)

---

## PHASE 4: GESTION DES PAIEMENTS (ADMIN)

### 4.1 - Générer les Échéances Automatiquement
**Route:** Admin > Inscriptions
1. Cliquer sur une inscription: "JOHNSON Alice"
2. Cliquer le bouton "Générer Échéances" ou via Admin > Échéances
3. Confirmer la génération de 10 échéances (Oct-Juillet)
✅ "10 échéances générées automatiquement"

### 4.2 - Consulter la Liste des Échéances
**Route:** Admin > Échéances
✅ Voir la table avec:
- Mois: "Octobre 2024-2025", "Novembre 2024-2025", etc.
- Étudiant: JOHNSON Alice
- Montant: 10 000 FCFA (100 000 / 10)
- Statut: "En attente"

### 4.3 - Enregistrer un Paiement
**Route:** Admin > Échéances
1. Sur une échéance en attente, cliquer "Payer"
2. Modal s'ouvre:
   - Montant à payer: `5000`
3. Cliquer "Enregistrer"
✅ "Paiement enregistré" + Badge passe à "Partiel"

### 4.4 - Payer Complètement une Échéance
**Route:** Admin > Échéances
1. Cliquer "Payer" sur une autre échéance
2. Montant à payer: `10000` (montant total)
3. Cliquer "Enregistrer"
✅ Badge passe à "Payé" ✓

### 4.5 - Éditer une Échéance
**Route:** Admin > Échéances
1. Cliquer le bouton ✏️ (Éditer)
2. Modifier:
   - Montant: `12000`
3. Cliquer "Mettre à jour"
✅ "Échéance mise à jour avec succès"

### 4.6 - Supprimer une Échéance
**Route:** Admin > Échéances
1. Cliquer le bouton 🗑️ (Supprimer)
2. Confirmer: "Êtes-vous sûr?"
✅ "Échéance supprimée avec succès"

### 4.7 - Consulter les Paiements Globaux
**Route:** Admin > Paiements
✅ Affiche tous les paiements effectués dans le système

---

## PHASE 5: RÉINSCRIPTION

### 5.1 - Accéder à la Réinscription
**Route:** Admin > Étudiants
1. Cliquer sur un étudiant: "JOHNSON Alice"
2. Cliquer bouton "Réinscrire"
✅ Redirection vers formulaire réinscription

### 5.2 - Vérifier l'Historique d'Inscription
✅ Voir tableau:
- Année: 2024-2025 (En cours)
- Classe: Seconde A
- Type: Nouvelle
- Paiement: En attente

### 5.3 - Créer la Réinscription pour Année Suivante
1. Sélectionner:
   - Classe: `Première C` (pour progresser)
   - Statut Paiement: `En attente`
2. Cliquer "Confirmer la réinscription"
✅ "Réinscription effectuée avec succès" + Notification envoyée à l'étudiant

### 5.4 - Vérifier Nouvelle Inscription
**Route:** Admin > Inscriptions
✅ Nouvelle inscription visible:
- Étudiant: JOHNSON Alice
- Année: 2024-2025
- Classe: Première C
- Type: Réinscription

---

## PHASE 6: TOGGLE THÈME

### 6.1 - Tester le Toggle Thème (Mode Sombre)
**Localisation:** Icône 🌞/🌙 en haut à droite (barre navbar)
1. Cliquer sur l'icône (actuellement soleil jaune 🌞)
2. Icône change en lune bleue 🌙
3. L'interface passe en **mode sombre**
✅ Tous les éléments changent de couleur
✅ Champ, tables, cards, modales: tous sombres

### 6.2 - Revenir au Mode Clair
1. Cliquer à nouveau sur l'icône (lune 🌙)
2. Icône change en soleil 🌞
3. L'interface revient en **mode clair**
✅ Interface claire à nouveau

### 6.3 - Vérifier la Persistance
1. Mode sombre Activé
2. Rafraîchir la page (F5)
✅ Reste en mode sombre (localStorage)
3. Se déconnecter et reconnecter
✅ Mode sombre persiste (session)

---

## PHASE 7: CAS LIMITES & SÉCURITÉ

### 7.1 - Tester Accès Non-Autorisé
1. Prof10 essaie d'accéder à `/admin/dashboard`
✅ Redirection vers `/prof/dashboard`

2. Étudiant essaie d'accéder à `/admin/inscriptions`
✅ Redirection vers `/eleve/dashboard`

### 7.2 - Tester Validation des Formulaires
**Admin > Étudiants > Créer
1. Laisser Matricule vide
2. Cliquer "Créer"
✅ Erreur: "Le champ matricule est requis"

1. Email invalide: `notanemail`
✅ Erreur: "Le champ email doit être une adresse email valide"

### 7.3 - Tester Inscriptions Doublons
**Admin > Inscriptions
1. Essayer inscrire JOHNSON Alice pour 2024-2025 à nouveau
✅ Erreur: "Cet étudiant est déjà inscrit pour cette année scolaire"

### 7.4 - Tester Réinscription avec Vérification
**Admin > Étudiants > JOHNSON Alice > Réinscrire
1. Mettre classe à "Première C"
2. Vérifier le message d'avertissement (si déjà inscrite)
✅ Message d'avertissement s'affiche si applicable

---

## PHASE 8: CHANGEMENT D'ANNÉE SCOLAIRE

### 8.1 - Créer une Nouvelle Année à Venir
**Route:** Admin > Années Scolaires
1. Créer: "2025-2026" avec statut "À venir"
✅ Créée avec succès

### 8.2 - Activer la Nouvelle Année
**Route:** Admin > Années Scolaires
1. Cliquer ✓ pour activer "2025-2026"
✅ Message: "Année 2025-2026 activée avec succès"
✅ L'année 2024-2025 passe à "inactive"

### 8.3 - Tester la Nouvelle Année pour Étudiant
**Élève > Connexion**
1. Déconnecter et reconnecter
✅ Sélection d'année affiche "2025-2026 (En cours)" comme option

### 8.4 - Vérifier Inscriptions de l'Année Active Seulement
**Admin > Inscriptions
✅ Affiche automatiquement les inscriptions de 2025-2026 (année active)

---

## RÉSUMÉ DES TESTS

| Phase | Fonction | Statut |
|-------|----------|--------|
| 1 | Configuration Données de Base | ✅ |
| 2 | Activités Professeur | ✅ |
| 3 | Activités Étudiant | ✅ |
| 4 | Gestion Paiements | ✅ |
| 5 | Réinscription | ✅ |
| 6 | Toggle Thème | ✅ |
| 7 | Sécurité & Validation | ✅ |
| 8 | Changement Année | ✅ |

---

## COMPTES DE TEST CRÉÉS

### Admin:
- Email: `admin@school.cg`
- Password: (par défaut du système)

### Professeurs:
1. Jean DUPONT - `jean.dupont@school.cg` / `password`
2. Sophie MARTIN - `sophie.martin@school.cg` / `password`
3. Marc BERNARD - `marc.bernard@school.cg` / `password`

### Étudiants:
1. Alice JOHNSON - `alice.johnson@eleve.school.cg` / `password`
2. Bob WILLIAMS - `bob.williams@eleve.school.cg` / `password`
3. Carla BROWN - `carla.brown@eleve.school.cg` / `password`
4. David DAVIS - `david.davis@eleve.school.cg` / `password`
5. Emma MILLER - `emma.miller@eleve.school.cg` / `password`

---

## NOTES IMPORTANTES

⚠️ Tous les comptes créés avec password: `password`  
⚠️ Les notifications s'envoient automatiquement lors des actions (notes, devoirs, etc.)  
⚠️ Le thème est sauvegardé en localStorage + session  
⚠️ Les échéances se calculent automatiquement (10 mois: Oct-Juillet)  
⚠️ Seule l'année ACTIVE s'affiche pour les inscriptions

---

## CHECKLIST FINALE

- [ ] Toutes les années créées et une activée
- [ ] Toutes les classes créées
- [ ] Tous les enseignants créés avec comptes
- [ ] Tous les étudiants créés avec comptes
- [ ] Tous les étudiants inscrits pour l'année active
- [ ] Professeur peut ajouter notes (étudiants reçoivent notifications)
- [ ] Professeur peut créer devoirs/examens (admin reçoit notifications)
- [ ] Professeur peut partager ressources (téléchargeables par étudiants)
- [ ] Étudiant peut voir notes, devoirs, examens, ressources
- [ ] Étudiant peut télécharger ressources
- [ ] Admin peut gérer échéances et paiements
- [ ] Réinscription fonctionne correctement
- [ ] Toggle thème fonctionne (mode clair/sombre)
- [ ] Persistance du thème (localStorage + session)
- [ ] Validations des formulaires fonctionnent
- [ ] Contrôles d'accès par rôle fonctionnent
- [ ] Changement d'année scolaire fonctionne
