<?php
use CRM_Dogregistry_ExtensionUtil as E;

/**
 * Collection of upgrade steps.
 */
class CRM_Dogregistry_Upgrader extends CRM_Extension_Upgrader_Base {

  // By convention, functions that look like "function upgrade_NNNN()" are
  // upgrade tasks. They are executed in order (like Drupal's hook_update_N).

  /**
   * Example: Run an external SQL script when the module is installed.
   *
  public function install() {
    $this->executeSqlFile('sql/myinstall.sql');
  }

  /**
   * Example: Work with entities usually not available during the install step.
   *
   * This method can be used for any post-install tasks. For example, if a step
   * of your installation depends on accessing an entity that is itself
   * created during the installation (e.g., a setting or a managed entity), do
   * so here to avoid order of operation problems.
   *
  public function postInstall() {
    $customFieldId = civicrm_api3('CustomField', 'getvalue', array(
      'return' => array("id"),
      'name' => "customFieldCreatedViaManagedHook",
    ));
    civicrm_api3('Setting', 'create', array(
      'myWeirdFieldSetting' => array('id' => $customFieldId, 'weirdness' => 1),
    ));
  }

  /**
   * Example: Run an external SQL script when the module is uninstalled.
   *
  public function uninstall() {
   $this->executeSqlFile('sql/myuninstall.sql');
  }

  /**
   * Example: Run a simple query when a module is enabled.
   *
  public function enable() {
    CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 1 WHERE bar = "whiz"');
  }

  /**
   * Example: Run a simple query when a module is disabled.
   *
  public function disable() {
    CRM_Core_DAO::executeQuery('UPDATE foo SET is_active = 0 WHERE bar = "whiz"');
  }

  /**
   * Example: Run a couple simple queries.
   *
   * @return TRUE on success
   * @throws Exception
   *
  public function upgrade_4200() {
    $this->ctx->log->info('Applying update 4200');
    CRM_Core_DAO::executeQuery('UPDATE foo SET bar = "whiz"');
    CRM_Core_DAO::executeQuery('DELETE FROM bang WHERE willy = wonka(2)');
    return TRUE;
  } // */


  /**
   * Example: Run an external SQL script.
   *
   * @return TRUE on success
   * @throws Exception
  public function upgrade_4201() {
    $this->ctx->log->info('Applying update 4201');
    // this path is relative to the extension base dir
    $this->executeSqlFile('sql/upgrade_4201.sql');
    return TRUE;
  } // */
  public function upgrade_2510() {
    $this->ctx->log->info('Applying update 2510');
    $dao = new CRM_Core_DAO();

    $dao->query("SHOW TABLES LIKE 'civicrm_dog_breed'");
    
    if (!$dao->fetch()) {
      CRM_Core_DAO::executeQuery('CREATE TABLE civicrm_dog_breed ( id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT "Unique DogBreed ID", Breed text COMMENT "Dog Breed", PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci');
      $breeds = array(
        'Australian Cattle Dog' => E::ts('Australian Cattle Dog'),
        'Afghan Hound' => E::ts('Afghan Hound'),
        'Airedale Terrier' => E::ts('Airedale Terrier'),
        'Akita' => E::ts('Akita'),
        'Alaskan Husky' => E::ts('Alaskan Husky'),
        'Alaskan Malamute' => E::ts('Alaskan Malamute'),
        'All-American' => E::ts('All-American'),
        'All-Canadian' => E::ts('All-Canadian'),
        'American Eskimo Dog (Miniature)' => E::ts('American Eskimo Dog (Miniature)'),
        'American Eskimo Dog (Standard)' => E::ts('American Eskimo Dog (Standard)'),
        'American Eskimo Dog (Toy)' => E::ts('American Eskimo Dog (Toy)'),
        'American Pit Bull Terrier' => E::ts('American Pit Bull Terrier'),
        'American Staffordshire Terrier' => E::ts('American Staffordshire Terrier'),
        'Anatolian Shepherd Dog' => E::ts('Anatolian Shepherd Dog'),
        'Australian Kelpie' => E::ts('Australian Kelpie'),
        'Australian Shepherd' => E::ts('Australian Shepherd'),
        'Australian Stumpy Tail Cattle Dog' => E::ts('Australian Stumpy Tail Cattle Dog'),
        'Australian Terrier' => E::ts('Australian Terrier'),
        'Barbet' => E::ts('Barbet'),
        'Basenji' => E::ts('Basenji'),
        'Basset_Art_sien_Normand' => E::ts('Basset Artesien Normand'),
        'Basset Hound' => E::ts('Basset Hound'),
        'Beagle' => E::ts('Beagle'),
        'Bearded Collie' => E::ts('Bearded Collie'),
        'Beauceron' => E::ts('Beauceron'),
        'Bedlington Terrier' => E::ts('Bedlington Terrier'),
        'Belgian Shepherd Dog (Groenendael)' => E::ts('Belgian Shepherd Dog (Groenendael)'),
        'Belgian Shepherd Dog (Laekenois)' => E::ts('Belgian Shepherd Dog (Laekenois)'),
        'Belgian Shepherd Dog (Malinois)' => E::ts('Belgian Shepherd Dog (Malinois)'),
        'Belgian Shepherd Dog (Tervuren)' => E::ts('Belgian Shepherd Dog (Tervuren)'),
        'Berger Allemand' => E::ts('Berger Allemand'),
        'Berger Australien' => E::ts('Berger Australien'),
        'Berger belge (Tervueren)' => E::ts('Berger belge (Tervueren)'),
        'Berger des Pyrenees' => E::ts('Berger des Pyrenees'),
        'Berger Picard' => E::ts('Berger Picard'),
        'Berger Polonais De Plaine' => E::ts('Berger Polonais De Plaine'),
        'Berger Shetland' => E::ts('Berger Shetland'),
        'Bernese Mountain Dog' => E::ts('Bernese Mountain Dog'),
        'Bichon Frise' => E::ts('Bichon Frise'),
        'Black Russian Terrier' => E::ts('Black Russian Terrier'),
        'Bloodhound' => E::ts('Bloodhound'),
        'Boerboel' => E::ts('Boerboel'),
        'Bohemian Shepherd' => E::ts('Bohemian Shepherd'),
        'Border Collie' => E::ts('Border Collie'),
        'Border Terrier' => E::ts('Border Terrier'),
        'Borzoi' => E::ts('Borzoi'),
        'Boston Terrier' => E::ts('Boston Terrier'),
        'Bouvier des Flandres' => E::ts('Bouvier des Flandres'),
        'Boxer' => E::ts('Boxer'),
        'Braque Fran?ais (Gascogne)' => E::ts('Braque Fran?ais (Gascogne)'),
        'Braque Fran?ais (Pyrenees)' => E::ts('Braque Fran?ais (Pyrenees)'),
        'Briard' => E::ts('Briard'),
        'Bull Terrier' => E::ts('Bull Terrier'),
        'Bull Terrier (Miniature)' => E::ts('Bull Terrier (Miniature)'),
        'Bulldog (American)' => E::ts('Bulldog (American)'),
        'Bulldog (English)' => E::ts('Bulldog (English)'),
        'Bullmastiff' => E::ts('Bullmastiff'),
        'Cairn Terrier' => E::ts('Cairn Terrier'),
        'Canaan Dog' => E::ts('Canaan Dog'),
        'Canadian Eskimo Dog' => E::ts('Canadian Eskimo Dog'),
        'Cane Corso' => E::ts('Cane Corso'),
        'Catahoula Leopard Dog' => E::ts('Catahoula Leopard Dog'),
        'Cavalier King Charles Spaniel' => E::ts('Cavalier King Charles Spaniel'),
        'Cesky Terrier' => E::ts('Cesky Terrier'),
        'Chihuahua' => E::ts('Chihuahua'),
        'Chihuahua (Long Coat)' => E::ts('Chihuahua (Long Coat)'),
        'Chihuahua (Short Coat)' => E::ts('Chihuahua (Short Coat)'),
        'Chinese Crested Dog' => E::ts('Chinese Crested Dog'),
        'Chinese Shar-Pei' => E::ts('Chinese Shar-Pei'),
        'Chow Chow' => E::ts('Chow Chow'),
        'Collie (Rough)' => E::ts('Collie (Rough)'),
        'Collie (Smooth)' => E::ts('Collie (Smooth)'),
        'Collie-x' => E::ts('Collie-x'),
        'Coolie' => E::ts('Coolie'),
        'Coonhound (Black & Tan)' => E::ts('Coonhound (Black & Tan)'),
        'Coonhound (Redbone)' => E::ts('Coonhound (Redbone)'),
        'Coton de Tulear' => E::ts('Coton de Tulear'),
        'Coydog' => E::ts('Coydog'),
        'Dachshund (Miniature Long-Haired)' => E::ts('Dachshund (Miniature Long-Haired)'),
        'Dachshund (Miniature Smooth)' => E::ts('Dachshund (Miniature Smooth)'),
        'Dachshund (Miniature Wire-Haired)' => E::ts('Dachshund (Miniature Wire-Haired)'),
        'Dachshund (Standard Long-Haired)' => E::ts('Dachshund (Standard Long-Haired)'),
        'Dachshund (Standard Smooth)' => E::ts('Dachshund (Standard Smooth)'),
        'Dachshund (Standard Wire-Haired)' => E::ts('Dachshund (Standard Wire-Haired)'),
        'Dalmatian' => E::ts('Dalmatian'),
        'Dandie Dinmont Terrier' => E::ts('Dandie Dinmont Terrier'),
        'Deerhound (Scottish)' => E::ts('Deerhound (Scottish)'),
        'Desi Dog' => E::ts('Desi Dog'),
        'Deutscher Jagdterrier' => E::ts('Deutscher Jagdterrier'),
        'Doberman Pinscher' => E::ts('Doberman Pinscher'),
        'Donovan Pinscher' => E::ts('Donovan Pinscher'),
        'Drever' => E::ts('Drever'),
        'Dutch Sheepdog' => E::ts('Dutch Sheepdog'),
        'Dutch Shepherd' => E::ts('Dutch Shepherd'),
        'English Shepherd' => E::ts('English Shepherd'),
        'English Toy Spaniel' => E::ts('English Toy Spaniel'),
        'Entlebucher Mountain Dog' => E::ts('Entlebucher Mountain Dog'),
        'Eurasier' => E::ts('Eurasier'),
        'Finnish Lapphund' => E::ts('Finnish Lapphund'),
        'Finnish Spitz' => E::ts('Finnish Spitz'),
        'Fox Terrier (Smooth)' => E::ts('Fox Terrier (Smooth)'),
        'Fox Terrier (Wire)' => E::ts('Fox Terrier (Wire)'),
        'Foxhound (American)' => E::ts('Foxhound (American)'),
        'Foxhound (English)' => E::ts('Foxhound (English)'),
        'French Bulldog' => E::ts('French Bulldog'),
        'German Coolie' => E::ts('German Coolie'),
        'German Pinscher' => E::ts('German Pinscher'),
        'German Shepherd Dog' => E::ts('German Shepherd Dog'),
        'Glen of Imaal' => E::ts('Glen of Imaal'),
        'Great Dane' => E::ts('Great Dane'),
        'Great Pyrenees' => E::ts('Great Pyrenees'),
        'Greater Swiss Mountain Dog' => E::ts('Greater Swiss Mountain Dog'),
        'Greenland Dog' => E::ts('Greenland Dog'),
        'Greyhound' => E::ts('Greyhound'),
        'Griffon (Brussels)' => E::ts('Griffon (Brussels)'),
        'Griffon (Wire-Haired Pointing)' => E::ts('Griffon (Wire-Haired Pointing)'),
        'Harrier' => E::ts('Harrier'),
        'Havanese' => E::ts('Havanese'),
        'Hovawart' => E::ts('Hovawart'),
        'Husky-x' => E::ts('Husky-x'),
        'Ibizan Hound' => E::ts('Ibizan Hound'),
        'Iceland Sheepdog' => E::ts('Iceland Sheepdog'),
        'Irish Terrier' => E::ts('Irish Terrier'),
        'Irish Wolfhound' => E::ts('Irish Wolfhound'),
        'Italian Greyhound' => E::ts('Italian Greyhound'),
        'Jack Russell Terrier' => E::ts('Jack Russell Terrier'),
        'Jack Russell Terrier x' => E::ts('Jack Russell Terrier x'),
        'Japanese Spaniel' => E::ts('Japanese Spaniel'),
        'Japanese Spitz' => E::ts('Japanese Spitz'),
        'Kai Ken' => E::ts('Kai Ken'),
        'Karelian Bear Dog' => E::ts('Karelian Bear Dog'),
        'Keeshond' => E::ts('Keeshond'),
        'Kerry Blue Terrier' => E::ts('Kerry Blue Terrier'),
        'Komondor' => E::ts('Komondor'),
        'Kooikerhondje' => E::ts('Kooikerhondje'),
        'Kuvasz' => E::ts('Kuvasz'),
        'Lagotto Romagnolo' => E::ts('Lagotto Romagnolo'),
        'Lakeland Terrier' => E::ts('Lakeland Terrier'),
        'Lancashire Heeler' => E::ts('Lancashire Heeler'),
        'Leonberger' => E::ts('Leonberger'),
        'Lhasa Apso' => E::ts('Lhasa Apso'),
        'Lowchen' => E::ts('Lowchen'),
        'Maltese' => E::ts('Maltese'),
        'Manchester Terrier' => E::ts('Manchester Terrier'),
        'Mastiff' => E::ts('Mastiff'),
        'Miniature American Shepherd' => E::ts('Miniature American Shepherd'),
        'Miniature Australian Shepherd' => E::ts('Miniature Australian Shepherd'),
        'Miniature Pinscher' => E::ts('Miniature Pinscher'),
        'Miniature Teckel' => E::ts('Miniature Teckel'),
        'Mudi' => E::ts('Mudi'),
        'Neapolitan Mastiff' => E::ts('Neapolitan Mastiff'),
        'Newfoundland' => E::ts('Newfoundland'),
        'Norfolk Terrier' => E::ts('Norfolk Terrier'),
        'Norrbottenspets' => E::ts('Norrbottenspets'),
        'Norwegian Buhund' => E::ts('Norwegian Buhund'),
        'Norwegian Elkhound' => E::ts('Norwegian Elkhound'),
        'Norwegian Lundehund' => E::ts('Norwegian Lundehund'),
        'Norwich Terrier' => E::ts('Norwich Terrier'),
        'Old English Sheepdog' => E::ts('Old English Sheepdog'),
        'Otterhound' => E::ts('Otterhound'),
        'Papillon' => E::ts('Papillon'),
        'Parson Russell Terrier' => E::ts('Parson Russell Terrier'),
        'Patterdale Terrier' => E::ts('Patterdale Terrier'),
        'Pekingese' => E::ts('Pekingese'),
        'Petit Basset Griffon Vendeen' => E::ts('Petit Basset Griffon Vendeen'),
        'Pharaoh Hound' => E::ts('Pharaoh Hound'),
        'Pharaoh_Hound_Miniature_' => E::ts('Pharaoh Hound (Miniature)'),
        'Pointer' => E::ts('Pointer'),
        'Pointer (English)' => E::ts('Pointer (English)'),
        'Pointer (German Long-Haired)' => E::ts('Pointer (German Long-Haired)'),
        'Pointer (German Short-Haired)' => E::ts('Pointer (German Short-Haired)'),
        'Pointer (German Wire-Haired)' => E::ts('Pointer (German Wire-Haired)'),
        'Polish Lowland Sheepdog' => E::ts('Polish Lowland Sheepdog'),
        'Pomeranian' => E::ts('Pomeranian'),
        'Poodle (Miniature)' => E::ts('Poodle (Miniature)'),
        'Poodle (Moyen)' => E::ts('Poodle (Moyen)'),
        'Poodle (Standard)' => E::ts('Poodle (Standard)'),
        'Poodle (Toy)' => E::ts('Poodle (Toy)'),
        'Poodle-x' => E::ts('Poodle-x'),
        'Portuguese Sheepdog' => E::ts('Portuguese Sheepdog'),
        'Portuguese Water Dog' => E::ts('Portuguese Water Dog'),
        'Potcake' => E::ts('Potcake'),
        'Presa Canario' => E::ts('Presa Canario'),
        'Pudelpointer' => E::ts('Pudelpointer'),
        'Pug' => E::ts('Pug'),
        'Puli' => E::ts('Puli'),
        'Pumi' => E::ts('Pumi'),
        'Rat Terrier' => E::ts('Rat Terrier'),
        'Redbone Coonhound' => E::ts('Redbone Coonhound'),
        'Retriever (Chesapeake Bay)' => E::ts('Retriever (Chesapeake Bay)'),
        'Retriever (Curly-Coated)' => E::ts('Retriever (Curly-Coated)'),
        'Retriever (Flat-Coated)' => E::ts('Retriever (Flat-Coated)'),
        'Retriever (Golden)' => E::ts('Retriever (Golden)'),
        'Retriever (Labrador)' => E::ts('Retriever (Labrador)'),
        'Retriever (Nova Scotia Duck Tolling)' => E::ts('Retriever (Nova Scotia Duck Tolling)'),
        'Rhodesian Ridgeback' => E::ts('Rhodesian Ridgeback'),
        'Rottweiler' => E::ts('Rottweiler'),
        'Saluki' => E::ts('Saluki'),
        'Samoyed' => E::ts('Samoyed'),
        'Schapendoes' => E::ts('Schapendoes'),
        'Schipperke' => E::ts('Schipperke'),
        'Schnauzer (Miniature)' => E::ts('Schnauzer (Miniature)'),
        'Schnauzer(Giant)' => E::ts('Schnauzer(Giant)'),
        'Schnauzer(Standard)' => E::ts('Schnauzer(Standard)'),
        'Scottish Terrier' => E::ts('Scottish Terrier'),
        'Sealyham Terrier' => E::ts('Sealyham Terrier'),
        'Setter (English)' => E::ts('Setter (English)'),
        'Setter (Gordon)' => E::ts('Setter (Gordon)'),
        'Setter (Irish Red & White)' => E::ts('Setter (Irish Red & White)'),
        'Setter (Irish)' => E::ts('Setter (Irish)'),
        'Shepherd-x' => E::ts('Shepherd-x'),
        'Shetland Sheepdog' => E::ts('Shetland Sheepdog'),
        'Shi-Tszu-x' => E::ts('Shi-Tszu-x'),
        'Shiba Inu' => E::ts('Shiba Inu'),
        'Shih Tzu' => E::ts('Shih Tzu'),
        'Shiloh Shepherd' => E::ts('Shiloh Shepherd'),
        'Siberian Husky' => E::ts('Siberian Husky'),
        'Silken Windhound' => E::ts('Silken Windhound'),
        'Silky Terrier' => E::ts('Silky Terrier'),
        'Skye Terrier' => E::ts('Skye Terrier'),
        'Small Munsterlander' => E::ts('Small Munsterlander'),
        'Soft-Coated Wheaten Terrier' => E::ts('Soft-Coated Wheaten Terrier'),
        'Spaniel (American Cocker)' => E::ts('Spaniel (American Cocker)'),
        'Spaniel (American Water)' => E::ts('Spaniel (American Water)'),
        'Spaniel (Blue Picardy)' => E::ts('Spaniel (Blue Picardy)'),
        'Spaniel (Brittany)' => E::ts('Spaniel (Brittany)'),
        'Spaniel (Clumber)' => E::ts('Spaniel (Clumber)'),
        'Spaniel (English Cocker)' => E::ts('Spaniel (English Cocker)'),
        'Spaniel (English Springer)' => E::ts('Spaniel (English Springer)'),
        'Spaniel (Field)' => E::ts('Spaniel (Field)'),
        'Spaniel (French)' => E::ts('Spaniel (French)'),
        'Spaniel (Irish Water)' => E::ts('Spaniel (Irish Water)'),
        'Spaniel (Sussex)' => E::ts('Spaniel (Sussex)'),
        'Spaniel (Welsh Springer)' => E::ts('Spaniel (Welsh Springer)'),
        'Spanish Water Dog' => E::ts('Spanish Water Dog'),
        'Spinone Italiano' => E::ts('Spinone Italiano'),
        'Springer Anglais' => E::ts('Springer Anglais'),
        'St. Bernard' => E::ts('St. Bernard'),
        'Staffordshire Bull Terrier' => E::ts('Staffordshire Bull Terrier'),
        'Swedish Vallhund' => E::ts('Swedish Vallhund'),
        'Tatra Sheepdog' => E::ts('Tatra Sheepdog'),
        'Terrier blanc du West Highland' => E::ts('Terrier blanc du West Highland'),
        'Terrier Nu Americain' => E::ts('Terrier Nu Americain'),
        'Terrier-x' => E::ts('Terrier-x'),
        'Thai_Ridgeback' => E::ts('Thai Ridgeback'),
        'Tibetan Mastiff' => E::ts('Tibetan Mastiff'),
        'Tibetan Spaniel' => E::ts('Tibetan Spaniel'),
        'Tibetan Terrier' => E::ts('Tibetan Terrier'),
        'Toy Fox Terrier' => E::ts('Toy Fox Terrier'),
        'Toy Manchester Terrier' => E::ts('Toy Manchester Terrier'),
        'Vizsla (Smooth)' => E::ts('Vizsla (Smooth)'),
        'Vizsla (Wire-Haired)' => E::ts('Vizsla (Wire-Haired)'),
        'Weimaraner' => E::ts('Weimaraner'),
        'Welsh Corgi (Cardigan)' => E::ts('Welsh Corgi (Cardigan)'),
        'Welsh Corgi (Pembroke)' => E::ts('Welsh Corgi (Pembroke)'),
        'Welsh Terrier' => E::ts('Welsh Terrier'),
        'West Highland White Terrier' => E::ts('West Highland White Terrier'),
        'Whippet' => E::ts('Whippet'),
        'Xoloitzcuintli (Miniature & Standard)' => E::ts('Xoloitzcuintli (Miniature & Standard)'),
        'Xoloitzcuintli(Toy)' => E::ts('Xoloitzcuintli(Toy)'),
        'Yorkshire Terrier' => E::ts('Yorkshire Terrier')
        );
        foreach($breeds as $key=>&$val) {
          $query = "INSERT INTO civicrm_dog_breed (Breed) VALUES ( '".$key."' )";
          CRM_Core_DAO::executeQuery($query);

        }
    }
    
    return TRUE;
  }

  /**
   * Example: Run a slow upgrade process by breaking it up into smaller chunk.
   *
   * @return TRUE on success
   * @throws Exception
  public function upgrade_4202() {
    $this->ctx->log->info('Planning update 4202'); // PEAR Log interface

    $this->addTask(E::ts('Process first step'), 'processPart1', $arg1, $arg2);
    $this->addTask(E::ts('Process second step'), 'processPart2', $arg3, $arg4);
    $this->addTask(E::ts('Process second step'), 'processPart3', $arg5);
    return TRUE;
  }
  public function processPart1($arg1, $arg2) { sleep(10); return TRUE; }
  public function processPart2($arg3, $arg4) { sleep(10); return TRUE; }
  public function processPart3($arg5) { sleep(10); return TRUE; }
  // */


  /**
   * Example: Run an upgrade with a query that touches many (potentially
   * millions) of records by breaking it up into smaller chunks.
   *
   * @return TRUE on success
   * @throws Exception
  public function upgrade_4203() {
    $this->ctx->log->info('Planning update 4203'); // PEAR Log interface

    $minId = CRM_Core_DAO::singleValueQuery('SELECT coalesce(min(id),0) FROM civicrm_contribution');
    $maxId = CRM_Core_DAO::singleValueQuery('SELECT coalesce(max(id),0) FROM civicrm_contribution');
    for ($startId = $minId; $startId <= $maxId; $startId += self::BATCH_SIZE) {
      $endId = $startId + self::BATCH_SIZE - 1;
      $title = E::ts('Upgrade Batch (%1 => %2)', array(
        1 => $startId,
        2 => $endId,
      ));
      $sql = '
        UPDATE civicrm_contribution SET foobar = whiz(wonky()+wanker)
        WHERE id BETWEEN %1 and %2
      ';
      $params = array(
        1 => array($startId, 'Integer'),
        2 => array($endId, 'Integer'),
      );
      $this->addTask($title, 'executeSql', $sql, $params);
    }
    return TRUE;
  } // */

}
