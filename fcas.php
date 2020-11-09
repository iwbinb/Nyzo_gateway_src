<html>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<div id="container-analysis" style="height: 400px; min-width: 310px"></div>
<script>
var list_coins = [
  {
    "symbol": "1ST",
    "related_assets": null,
    "name": "FirstBlood"
  },
  {
    "symbol": "ABT",
    "related_assets": null,
    "name": "Arcblock"
  },
  {
    "symbol": "ABYSS",
    "related_assets": null,
    "name": "The Abyss"
  },
  {
    "symbol": "ADA",
    "related_assets": null,
    "name": "Cardano"
  },
  {
    "symbol": "ADT",
    "related_assets": null,
    "name": "AdChain"
  },
  {
    "symbol": "ADX",
    "related_assets": null,
    "name": "AdEx"
  },
  {
    "symbol": "AE",
    "related_assets": null,
    "name": "Aeternity"
  },
  {
    "symbol": "AEON",
    "related_assets": null,
    "name": "AeonCoin"
  },
  {
    "symbol": "AGI",
    "related_assets": null,
    "name": "SingularityNET"
  },
  {
    "symbol": "AION",
    "related_assets": null,
    "name": "Aion"
  },
  {
    "symbol": "AIT",
    "related_assets": null,
    "name": "AICHAIN"
  },
  {
    "symbol": "ALIS",
    "related_assets": null,
    "name": "Alis"
  },
  {
    "symbol": "AMB",
    "related_assets": null,
    "name": "Ambrosus"
  },
  {
    "symbol": "AMO",
    "related_assets": null,
    "name": "Amo Coin"
  },
  {
    "symbol": "AMP",
    "related_assets": null,
    "name": "Synereo"
  },
  {
    "symbol": "ANT",
    "related_assets": null,
    "name": "Aragon"
  },
  {
    "symbol": "APIS",
    "related_assets": null,
    "name": "APIS"
  },
  {
    "symbol": "APPC",
    "related_assets": null,
    "name": "AppCoins"
  },
  {
    "symbol": "ARDR",
    "related_assets": null,
    "name": "Ardor"
  },
  {
    "symbol": "ARK",
    "related_assets": null,
    "name": "ARK"
  },
  {
    "symbol": "ARN",
    "related_assets": null,
    "name": "Aeron"
  },
  {
    "symbol": "ART",
    "related_assets": null,
    "name": "Maecenas"
  },
  {
    "symbol": "AST",
    "related_assets": null,
    "name": "AirSwap"
  },
  {
    "symbol": "ATX",
    "related_assets": null,
    "name": "Aston"
  },
  {
    "symbol": "AURA",
    "related_assets": null,
    "name": "Aurora DAO"
  },
  {
    "symbol": "AUTO",
    "related_assets": null,
    "name": "Cube"
  },
  {
    "symbol": "BANCA",
    "related_assets": null,
    "name": "Banca"
  },
  {
    "symbol": "BAT",
    "related_assets": null,
    "name": "Basic Attention Token"
  },
  {
    "symbol": "BAX",
    "related_assets": null,
    "name": "BABB"
  },
  {
    "symbol": "BAY",
    "related_assets": null,
    "name": "BitBay"
  },
  {
    "symbol": "BBC",
    "related_assets": null,
    "name": "TraDove B2BCoin"
  },
  {
    "symbol": "BBK",
    "related_assets": null,
    "name": "BitBlocks"
  },
  {
    "symbol": "BCH",
    "related_assets": null,
    "name": "BitcoinCash"
  },
  {
    "symbol": "BCI",
    "related_assets": null,
    "name": "Bitcoin Interest"
  },
  {
    "symbol": "BCN",
    "related_assets": null,
    "name": "ByteCoin"
  },
  {
    "symbol": "BCPT",
    "related_assets": null,
    "name": "BlockMason Credit Protocol"
  },
  {
    "symbol": "BDG",
    "related_assets": null,
    "name": "BitDegree"
  },
  {
    "symbol": "BEE",
    "related_assets": null,
    "name": "Bee Token"
  },
  {
    "symbol": "BERRY",
    "related_assets": null,
    "name": "Rentberry"
  },
  {
    "symbol": "BET",
    "related_assets": null,
    "name": "DAO Casino"
  },
  {
    "symbol": "BEZ",
    "related_assets": null,
    "name": "Bezop"
  },
  {
    "symbol": "BIX",
    "related_assets": null,
    "name": "Bibox Token"
  },
  {
    "symbol": "BKX",
    "related_assets": null,
    "name": "Bankex"
  },
  {
    "symbol": "BLK",
    "related_assets": null,
    "name": "BlackCoin"
  },
  {
    "symbol": "BLOCK",
    "related_assets": null,
    "name": "Blocknet"
  },
  {
    "symbol": "BLT",
    "related_assets": null,
    "name": "Bloom"
  },
  {
    "symbol": "BLZ",
    "related_assets": null,
    "name": "Bluzelle"
  },
  {
    "symbol": "BMC",
    "related_assets": null,
    "name": "Blackmoon Crypto"
  },
  {
    "symbol": "BNB",
    "related_assets": null,
    "name": "Binance Coin"
  },
  {
    "symbol": "BNT",
    "related_assets": null,
    "name": "Bancor Network Token"
  },
  {
    "symbol": "BOT",
    "related_assets": null,
    "name": "Bodhi"
  },
  {
    "symbol": "BPT",
    "related_assets": null,
    "name": "Blockport"
  },
  {
    "symbol": "BRD",
    "related_assets": null,
    "name": "Bread"
  },
  {
    "symbol": "BTC",
    "related_assets": null,
    "name": "Bitcoin"
  },
  {
    "symbol": "BTCP",
    "related_assets": null,
    "name": "Bitcoin Private"
  },
  {
    "symbol": "BTG",
    "related_assets": null,
    "name": "Bitcoin Gold"
  },
  {
    "symbol": "BTM",
    "related_assets": null,
    "name": "Bitmark"
  },
  {
    "symbol": "BTO",
    "related_assets": null,
    "name": "Bottos"
  },
  {
    "symbol": "BTS",
    "related_assets": null,
    "name": "Bitshares"
  },
  {
    "symbol": "BTX",
    "related_assets": null,
    "name": "Bitcore"
  },
  {
    "symbol": "BZNT",
    "related_assets": null,
    "name": "Bezant"
  },
  {
    "symbol": "C20",
    "related_assets": null,
    "name": "CRYPTO20"
  },
  {
    "symbol": "CAPP",
    "related_assets": null,
    "name": "Cappasity"
  },
  {
    "symbol": "CAS",
    "related_assets": null,
    "name": "Cashaa"
  },
  {
    "symbol": "CBC",
    "related_assets": null,
    "name": "CashBet Coin"
  },
  {
    "symbol": "CBT",
    "related_assets": null,
    "name": "CommerceBlock"
  },
  {
    "symbol": "CDT",
    "related_assets": null,
    "name": "CoinDash"
  },
  {
    "symbol": "CHAT",
    "related_assets": null,
    "name": "OpenChat"
  },
  {
    "symbol": "CHP",
    "related_assets": null,
    "name": "CoinPoker"
  },
  {
    "symbol": "CHSB",
    "related_assets": null,
    "name": "SwissBorg"
  },
  {
    "symbol": "CLAM",
    "related_assets": null,
    "name": "CLAMS"
  },
  {
    "symbol": "CLO",
    "related_assets": null,
    "name": "Callisto Network"
  },
  {
    "symbol": "CMT",
    "related_assets": null,
    "name": "CyberMiles"
  },
  {
    "symbol": "CND",
    "related_assets": null,
    "name": "Cindicator"
  },
  {
    "symbol": "CNN",
    "related_assets": null,
    "name": "Content Neutrality Network"
  },
  {
    "symbol": "CNX",
    "related_assets": null,
    "name": "Cryptonex"
  },
  {
    "symbol": "COB",
    "related_assets": null,
    "name": "Cobinhood"
  },
  {
    "symbol": "COFI",
    "related_assets": null,
    "name": "CoinFi"
  },
  {
    "symbol": "COLX",
    "related_assets": null,
    "name": "ColossusCoinXT"
  },
  {
    "symbol": "COSS",
    "related_assets": null,
    "name": "COSS"
  },
  {
    "symbol": "COV",
    "related_assets": null,
    "name": "Covesting"
  },
  {
    "symbol": "CPC",
    "related_assets": null,
    "name": "CapriCoin"
  },
  {
    "symbol": "CPT",
    "related_assets": null,
    "name": "Cryptaur"
  },
  {
    "symbol": "CREDO",
    "related_assets": null,
    "name": "Credo"
  },
  {
    "symbol": "CRPT",
    "related_assets": null,
    "name": "Crypterium"
  },
  {
    "symbol": "CRW",
    "related_assets": null,
    "name": "Crown Coin"
  },
  {
    "symbol": "CS",
    "related_assets": null,
    "name": "Credits"
  },
  {
    "symbol": "CSC",
    "related_assets": null,
    "name": "CasinoCoin"
  },
  {
    "symbol": "CTXC",
    "related_assets": null,
    "name": "Cortex"
  },
  {
    "symbol": "CV",
    "related_assets": null,
    "name": "carVertical"
  },
  {
    "symbol": "CVC",
    "related_assets": null,
    "name": "Civic"
  },
  {
    "symbol": "DADI",
    "related_assets": null,
    "name": "DADI"
  },
  {
    "symbol": "DAG",
    "related_assets": null,
    "name": "Constellation"
  },
  {
    "symbol": "DAI",
    "related_assets": null,
    "name": "Dai"
  },
  {
    "symbol": "DASH",
    "related_assets": null,
    "name": "Dash"
  },
  {
    "symbol": "DAT",
    "related_assets": null,
    "name": "Datum"
  },
  {
    "symbol": "DATA",
    "related_assets": null,
    "name": "Streamr DATAcoin"
  },
  {
    "symbol": "DAV",
    "related_assets": null,
    "name": "DavorCoin"
  },
  {
    "symbol": "DAX",
    "related_assets": null,
    "name": "DAEX"
  },
  {
    "symbol": "DAY",
    "related_assets": null,
    "name": "Chronologic"
  },
  {
    "symbol": "DBET",
    "related_assets": null,
    "name": "DecentBet"
  },
  {
    "symbol": "DCC",
    "related_assets": null,
    "name": "Distributed Credit Chain"
  },
  {
    "symbol": "DCN",
    "related_assets": null,
    "name": "Dentacoin"
  },
  {
    "symbol": "DCR",
    "related_assets": null,
    "name": "Decred"
  },
  {
    "symbol": "DCT",
    "related_assets": null,
    "name": "Decent"
  },
  {
    "symbol": "DENT",
    "related_assets": null,
    "name": "Dent"
  },
  {
    "symbol": "DEV",
    "related_assets": null,
    "name": "Deviant Coin"
  },
  {
    "symbol": "DGB",
    "related_assets": null,
    "name": "DigiByte"
  },
  {
    "symbol": "DGD",
    "related_assets": null,
    "name": "DigixDAO"
  },
  {
    "symbol": "DGTX",
    "related_assets": null,
    "name": "Digitex Futures"
  },
  {
    "symbol": "DICE",
    "related_assets": null,
    "name": "Dice"
  },
  {
    "symbol": "DLT",
    "related_assets": null,
    "name": "Agrello"
  },
  {
    "symbol": "DMD",
    "related_assets": null,
    "name": "Diamond"
  },
  {
    "symbol": "DMT",
    "related_assets": null,
    "name": "DMarket"
  },
  {
    "symbol": "DNA",
    "related_assets": null,
    "name": "EncrypGen"
  },
  {
    "symbol": "DNT",
    "related_assets": null,
    "name": "district0x"
  },
  {
    "symbol": "DOCK",
    "related_assets": null,
    "name": "Dock"
  },
  {
    "symbol": "DOGE",
    "related_assets": null,
    "name": "Dogecoin"
  },
  {
    "symbol": "DOV",
    "related_assets": null,
    "name": "Dovu"
  },
  {
    "symbol": "DPY",
    "related_assets": null,
    "name": "Delphy"
  },
  {
    "symbol": "DRGN",
    "related_assets": null,
    "name": "Dragonchain"
  },
  {
    "symbol": "DROP",
    "related_assets": null,
    "name": "Dropil"
  },
  {
    "symbol": "DRT",
    "related_assets": null,
    "name": "DomRaider"
  },
  {
    "symbol": "DTA",
    "related_assets": null,
    "name": "DATA"
  },
  {
    "symbol": "DTH",
    "related_assets": null,
    "name": "Dether"
  },
  {
    "symbol": "DXT",
    "related_assets": null,
    "name": "Datawallet"
  },
  {
    "symbol": "EDG",
    "related_assets": null,
    "name": "Edgeless Casino"
  },
  {
    "symbol": "EDO",
    "related_assets": null,
    "name": "Eidoo"
  },
  {
    "symbol": "EDR",
    "related_assets": null,
    "name": "E-Dinar Coin"
  },
  {
    "symbol": "EKO",
    "related_assets": null,
    "name": "EchoLink"
  },
  {
    "symbol": "EKT",
    "related_assets": null,
    "name": "EDUCare"
  },
  {
    "symbol": "ELEC",
    "related_assets": null,
    "name": "Electrify.Asia"
  },
  {
    "symbol": "ELF",
    "related_assets": null,
    "name": "aelf"
  },
  {
    "symbol": "EMC2",
    "related_assets": null,
    "name": "Einsteinium"
  },
  {
    "symbol": "ENG",
    "related_assets": null,
    "name": "Enigma"
  },
  {
    "symbol": "ENJ",
    "related_assets": null,
    "name": "Enjin Coin"
  },
  {
    "symbol": "EOS",
    "related_assets": null,
    "name": "Eos"
  },
  {
    "symbol": "ETC",
    "related_assets": null,
    "name": "Ethereum Classic"
  },
  {
    "symbol": "ETH",
    "related_assets": null,
    "name": "Ethereum"
  },
  {
    "symbol": "ETHOS",
    "related_assets": null,
    "name": "Ethos"
  },
  {
    "symbol": "ETN",
    "related_assets": null,
    "name": "Electroneum"
  },
  {
    "symbol": "ETP",
    "related_assets": null,
    "name": "Metaverse ETP"
  },
  {
    "symbol": "EVE",
    "related_assets": null,
    "name": "Devery"
  },
  {
    "symbol": "EVN",
    "related_assets": null,
    "name": "Envion"
  },
  {
    "symbol": "EVX",
    "related_assets": null,
    "name": "Everex"
  },
  {
    "symbol": "EXP",
    "related_assets": null,
    "name": "Expanse"
  },
  {
    "symbol": "EXY",
    "related_assets": null,
    "name": "Experty"
  },
  {
    "symbol": "FAIR",
    "related_assets": null,
    "name": "Fair Coin"
  },
  {
    "symbol": "FCT",
    "related_assets": null,
    "name": "Factom"
  },
  {
    "symbol": "FLASH",
    "related_assets": null,
    "name": "Flash"
  },
  {
    "symbol": "FLO",
    "related_assets": null,
    "name": "FlorinCoin"
  },
  {
    "symbol": "FNKOS",
    "related_assets": null,
    "name": "FNKOS"
  },
  {
    "symbol": "FOTA",
    "related_assets": null,
    "name": "Fortuna"
  },
  {
    "symbol": "FSN",
    "related_assets": null,
    "name": "Fusion"
  },
  {
    "symbol": "FTC",
    "related_assets": null,
    "name": "Feather Coin"
  },
  {
    "symbol": "FUEL",
    "related_assets": null,
    "name": "Etherparty"
  },
  {
    "symbol": "FUN",
    "related_assets": null,
    "name": "FunFair"
  },
  {
    "symbol": "FXT",
    "related_assets": null,
    "name": "FuzeX"
  },
  {
    "symbol": "GAME",
    "related_assets": null,
    "name": "Gamecredits"
  },
  {
    "symbol": "GAS",
    "related_assets": null,
    "name": "Gas"
  },
  {
    "symbol": "GBYTE",
    "related_assets": null,
    "name": "Byteball"
  },
  {
    "symbol": "GEM",
    "related_assets": null,
    "name": "Gems "
  },
  {
    "symbol": "GEN",
    "related_assets": null,
    "name": "DAOstack"
  },
  {
    "symbol": "GNO",
    "related_assets": null,
    "name": "Gnosis"
  },
  {
    "symbol": "GNT",
    "related_assets": null,
    "name": "Golem"
  },
  {
    "symbol": "GNX",
    "related_assets": null,
    "name": "Genaro Network"
  },
  {
    "symbol": "GOLOS",
    "related_assets": null,
    "name": "Golos"
  },
  {
    "symbol": "GOT",
    "related_assets": null,
    "name": "GoNetwork"
  },
  {
    "symbol": "GRC",
    "related_assets": null,
    "name": "GridCoin"
  },
  {
    "symbol": "GRID",
    "related_assets": null,
    "name": "Grid+"
  },
  {
    "symbol": "GRS",
    "related_assets": null,
    "name": "Groestlcoin "
  },
  {
    "symbol": "GSC",
    "related_assets": null,
    "name": "Global Social Chain"
  },
  {
    "symbol": "GTC",
    "related_assets": null,
    "name": "Game.com"
  },
  {
    "symbol": "GTO",
    "related_assets": null,
    "name": "GIFTO"
  },
  {
    "symbol": "GUP",
    "related_assets": null,
    "name": "Guppy"
  },
  {
    "symbol": "GVT",
    "related_assets": null,
    "name": "Genesis Vision"
  },
  {
    "symbol": "GXS",
    "related_assets": null,
    "name": "GXChain"
  },
  {
    "symbol": "HC",
    "related_assets": null,
    "name": "HyperCash"
  },
  {
    "symbol": "HER",
    "related_assets": null,
    "name": "HeroNode"
  },
  {
    "symbol": "HGT",
    "related_assets": null,
    "name": "Hello Gold"
  },
  {
    "symbol": "HKN",
    "related_assets": null,
    "name": "Hacken"
  },
  {
    "symbol": "HMQ",
    "related_assets": null,
    "name": "Humaniq"
  },
  {
    "symbol": "HOT",
    "related_assets": null,
    "name": "Hydro Protocol"
  },
  {
    "symbol": "HPB",
    "related_assets": null,
    "name": "High Performance Blockchain"
  },
  {
    "symbol": "HST",
    "related_assets": null,
    "name": "Decision Token"
  },
  {
    "symbol": "HT",
    "related_assets": null,
    "name": "Huobi Token"
  },
  {
    "symbol": "HTML",
    "related_assets": null,
    "name": "HTMLCOIN"
  },
  {
    "symbol": "HVN",
    "related_assets": null,
    "name": "Hive Project"
  },
  {
    "symbol": "HYDRO",
    "related_assets": null,
    "name": "Hydrogen"
  },
  {
    "symbol": "ICN",
    "related_assets": null,
    "name": "Iconomi"
  },
  {
    "symbol": "ICX",
    "related_assets": null,
    "name": "ICON Project"
  },
  {
    "symbol": "IDH",
    "related_assets": null,
    "name": "indaHash"
  },
  {
    "symbol": "IHT",
    "related_assets": null,
    "name": "IHT Real Estate Protocol"
  },
  {
    "symbol": "INK",
    "related_assets": null,
    "name": "Ink"
  },
  {
    "symbol": "INS",
    "related_assets": null,
    "name": "INS Ecosystem"
  },
  {
    "symbol": "INT",
    "related_assets": null,
    "name": "Internet Node Token"
  },
  {
    "symbol": "IOC",
    "related_assets": null,
    "name": "IOCoin"
  },
  {
    "symbol": "ION",
    "related_assets": null,
    "name": "Ionomy"
  },
  {
    "symbol": "IOST",
    "related_assets": null,
    "name": "IOStoken"
  },
  {
    "symbol": "IOTX",
    "related_assets": null,
    "name": "IoTeX"
  },
  {
    "symbol": "ITC",
    "related_assets": null,
    "name": "IoT Chain"
  },
  {
    "symbol": "IVY",
    "related_assets": null,
    "name": "Ivy"
  },
  {
    "symbol": "IXT",
    "related_assets": null,
    "name": "iXledger"
  },
  {
    "symbol": "JNT",
    "related_assets": null,
    "name": "Jibrel Network"
  },
  {
    "symbol": "JSE",
    "related_assets": null,
    "name": "JSEcoin"
  },
  {
    "symbol": "KCS",
    "related_assets": null,
    "name": "KuCoin Shares"
  },
  {
    "symbol": "KEY",
    "related_assets": null,
    "name": "Selfkey"
  },
  {
    "symbol": "KICK",
    "related_assets": null,
    "name": "KickCoin"
  },
  {
    "symbol": "KIN",
    "related_assets": null,
    "name": "Kin"
  },
  {
    "symbol": "KMD",
    "related_assets": null,
    "name": "Komodo"
  },
  {
    "symbol": "KNC",
    "related_assets": null,
    "name": "Kyber"
  },
  {
    "symbol": "LA",
    "related_assets": null,
    "name": "LATOKEN"
  },
  {
    "symbol": "LALA",
    "related_assets": null,
    "name": "LALA World"
  },
  {
    "symbol": "LBA",
    "related_assets": null,
    "name": "Libra Credit"
  },
  {
    "symbol": "LBC",
    "related_assets": null,
    "name": "Lbry"
  },
  {
    "symbol": "LEND",
    "related_assets": null,
    "name": "ETHLend"
  },
  {
    "symbol": "LEO",
    "related_assets": null,
    "name": "LEOcoin"
  },
  {
    "symbol": "LGO",
    "related_assets": null,
    "name": "Legolas Exchange"
  },
  {
    "symbol": "LIFE",
    "related_assets": null,
    "name": "LIFE"
  },
  {
    "symbol": "LIKE",
    "related_assets": null,
    "name": "LikeCoin"
  },
  {
    "symbol": "LINDA",
    "related_assets": null,
    "name": "Linda"
  },
  {
    "symbol": "LINK",
    "related_assets": null,
    "name": "ChainLink"
  },
  {
    "symbol": "LOC",
    "related_assets": null,
    "name": "LockChain"
  },
  {
    "symbol": "LOOM",
    "related_assets": null,
    "name": "Loom Network"
  },
  {
    "symbol": "LRC",
    "related_assets": null,
    "name": "Loopring"
  },
  {
    "symbol": "LSK",
    "related_assets": null,
    "name": "Lisk"
  },
  {
    "symbol": "LTC",
    "related_assets": null,
    "name": "Litecoin"
  },
  {
    "symbol": "LUN",
    "related_assets": null,
    "name": "Lunyr"
  },
  {
    "symbol": "LUX",
    "related_assets": null,
    "name": "LUXCoin"
  },
  {
    "symbol": "LYM",
    "related_assets": null,
    "name": "Lympo"
  },
  {
    "symbol": "MAID",
    "related_assets": null,
    "name": "MaidSafe Coin"
  },
  {
    "symbol": "MAN",
    "related_assets": null,
    "name": "People"
  },
  {
    "symbol": "MANA",
    "related_assets": null,
    "name": "Decentraland"
  },
  {
    "symbol": "MCO",
    "related_assets": null,
    "name": "Monaco"
  },
  {
    "symbol": "MDA",
    "related_assets": null,
    "name": "Moeda Loyalty Points"
  },
  {
    "symbol": "MDS",
    "related_assets": null,
    "name": "MediShares"
  },
  {
    "symbol": "MDT",
    "related_assets": null,
    "name": "Measurable Data Token"
  },
  {
    "symbol": "MET",
    "related_assets": null,
    "name": "Metronome"
  },
  {
    "symbol": "MGO",
    "related_assets": null,
    "name": "MobileGo"
  },
  {
    "symbol": "MIOTA",
    "related_assets": null,
    "name": "IOTA"
  },
  {
    "symbol": "MITH",
    "related_assets": null,
    "name": "Mithril"
  },
  {
    "symbol": "MKR",
    "related_assets": null,
    "name": "Maker"
  },
  {
    "symbol": "MLN",
    "related_assets": null,
    "name": "Melon"
  },
  {
    "symbol": "MNX",
    "related_assets": null,
    "name": "MinexCoin"
  },
  {
    "symbol": "MOAC",
    "related_assets": null,
    "name": "MOAC"
  },
  {
    "symbol": "MOBI",
    "related_assets": null,
    "name": "Mobius"
  },
  {
    "symbol": "MOD",
    "related_assets": null,
    "name": "Modum"
  },
  {
    "symbol": "MONA",
    "related_assets": null,
    "name": "Monacoin"
  },
  {
    "symbol": "MOT",
    "related_assets": null,
    "name": "Olympus Labs"
  },
  {
    "symbol": "MSP",
    "related_assets": null,
    "name": "Mothership"
  },
  {
    "symbol": "MTC",
    "related_assets": null,
    "name": "Docademic"
  },
  {
    "symbol": "MTH",
    "related_assets": null,
    "name": "Monetha"
  },
  {
    "symbol": "MTL",
    "related_assets": null,
    "name": "MetalPay"
  },
  {
    "symbol": "MTN",
    "related_assets": null,
    "name": "Medicalchain"
  },
  {
    "symbol": "MTX",
    "related_assets": null,
    "name": "Matryx"
  },
  {
    "symbol": "MUE",
    "related_assets": null,
    "name": "MonetaryUnit"
  },
  {
    "symbol": "MWAT",
    "related_assets": null,
    "name": "Restart Energy MWAT"
  },
  {
    "symbol": "MYST",
    "related_assets": null,
    "name": "Mysterium Network"
  },
  {
    "symbol": "NANO",
    "related_assets": null,
    "name": "Nano"
  },
  {
    "symbol": "NAS",
    "related_assets": null,
    "name": "Nebulas"
  },
  {
    "symbol": "NCASH",
    "related_assets": null,
    "name": "Nucleus Vision"
  },
  {
    "symbol": "NCT",
    "related_assets": null,
    "name": "PolySwarm"
  },
  {
    "symbol": "NEBL",
    "related_assets": null,
    "name": "Neblio"
  },
  {
    "symbol": "NEC",
    "related_assets": null,
    "name": "Nectar"
  },
  {
    "symbol": "NEO",
    "related_assets": null,
    "name": "NEO"
  },
  {
    "symbol": "NET",
    "related_assets": null,
    "name": "Nimiq"
  },
  {
    "symbol": "NEU",
    "related_assets": null,
    "name": "Neumark"
  },
  {
    "symbol": "NEXO",
    "related_assets": null,
    "name": "Nexo"
  },
  {
    "symbol": "NGC",
    "related_assets": null,
    "name": "NAGA"
  },
  {
    "symbol": "NLC2",
    "related_assets": null,
    "name": "NoLimitCoin"
  },
  {
    "symbol": "NLG",
    "related_assets": null,
    "name": "Gulden"
  },
  {
    "symbol": "NMC",
    "related_assets": null,
    "name": "NameCoin"
  },
  {
    "symbol": "NMR",
    "related_assets": null,
    "name": "Numerai"
  },
  {
    "symbol": "NOAH",
    "related_assets": null,
    "name": "NOAHCOIN"
  },
  {
    "symbol": "NOTE",
    "related_assets": null,
    "name": "Dnotes"
  },
  {
    "symbol": "NPXS",
    "related_assets": null,
    "name": "Pundi X"
  },
  {
    "symbol": "NTK",
    "related_assets": null,
    "name": "Neurotoken"
  },
  {
    "symbol": "NULS",
    "related_assets": null,
    "name": "Nuls"
  },
  {
    "symbol": "NVC",
    "related_assets": null,
    "name": "NovaCoin"
  },
  {
    "symbol": "NXS",
    "related_assets": null,
    "name": "Nexus"
  },
  {
    "symbol": "OAX",
    "related_assets": null,
    "name": "OAX"
  },
  {
    "symbol": "OCN",
    "related_assets": null,
    "name": "Odyssey"
  },
  {
    "symbol": "OMG",
    "related_assets": null,
    "name": "Omisego"
  },
  {
    "symbol": "OMNI",
    "related_assets": null,
    "name": "Omnicoin"
  },
  {
    "symbol": "OMX",
    "related_assets": null,
    "name": "Shivom"
  },
  {
    "symbol": "ONION",
    "related_assets": null,
    "name": "DeepOnion"
  },
  {
    "symbol": "ONT",
    "related_assets": null,
    "name": "Ontology"
  },
  {
    "symbol": "OPTI",
    "related_assets": null,
    "name": "OptiToken"
  },
  {
    "symbol": "ORME",
    "related_assets": null,
    "name": "Ormeus Coin"
  },
  {
    "symbol": "OST",
    "related_assets": null,
    "name": "OST"
  },
  {
    "symbol": "OXY",
    "related_assets": null,
    "name": "Oxycoin"
  },
  {
    "symbol": "PAI",
    "related_assets": null,
    "name": "PCHAIN"
  },
  {
    "symbol": "PARETO",
    "related_assets": null,
    "name": "Pareto Network"
  },
  {
    "symbol": "PART",
    "related_assets": null,
    "name": "Particl"
  },
  {
    "symbol": "PASC",
    "related_assets": null,
    "name": "Pascal Coin"
  },
  {
    "symbol": "PAY",
    "related_assets": null,
    "name": "TenX"
  },
  {
    "symbol": "PHR",
    "related_assets": null,
    "name": "Phore"
  },
  {
    "symbol": "PIVX",
    "related_assets": null,
    "name": "Private Instant Verified Transaction"
  },
  {
    "symbol": "PLBT",
    "related_assets": null,
    "name": "Polybius"
  },
  {
    "symbol": "PLR",
    "related_assets": null,
    "name": "Pillar"
  },
  {
    "symbol": "POA",
    "related_assets": null,
    "name": "POA Network"
  },
  {
    "symbol": "POE",
    "related_assets": null,
    "name": "Poet"
  },
  {
    "symbol": "POLY",
    "related_assets": null,
    "name": "Polymath"
  },
  {
    "symbol": "POT",
    "related_assets": null,
    "name": "Pot Coin"
  },
  {
    "symbol": "POWR",
    "related_assets": null,
    "name": "Power Ledger"
  },
  {
    "symbol": "PPC",
    "related_assets": null,
    "name": "PeerCoin"
  },
  {
    "symbol": "PPP",
    "related_assets": null,
    "name": "PayPie"
  },
  {
    "symbol": "PPT",
    "related_assets": null,
    "name": "Populous"
  },
  {
    "symbol": "PPY",
    "related_assets": null,
    "name": "Peerplays"
  },
  {
    "symbol": "PRA",
    "related_assets": null,
    "name": "ProChain"
  },
  {
    "symbol": "PRE",
    "related_assets": null,
    "name": "Presearch"
  },
  {
    "symbol": "PRG",
    "related_assets": null,
    "name": "Paragon"
  },
  {
    "symbol": "PRO",
    "related_assets": null,
    "name": "Propy"
  },
  {
    "symbol": "PST",
    "related_assets": null,
    "name": "Primas"
  },
  {
    "symbol": "PURA",
    "related_assets": null,
    "name": "Pura"
  },
  {
    "symbol": "QASH",
    "related_assets": null,
    "name": "QASH"
  },
  {
    "symbol": "QBIT",
    "related_assets": null,
    "name": "Qubitica"
  },
  {
    "symbol": "QBT",
    "related_assets": null,
    "name": "Cubits"
  },
  {
    "symbol": "QKC",
    "related_assets": null,
    "name": "QuarkChain"
  },
  {
    "symbol": "QLC",
    "related_assets": null,
    "name": "QLINK"
  },
  {
    "symbol": "QRL",
    "related_assets": null,
    "name": "Quantum Resistant Ledger"
  },
  {
    "symbol": "QSP",
    "related_assets": null,
    "name": "Quantstamp"
  },
  {
    "symbol": "QTUM",
    "related_assets": null,
    "name": "Qtum"
  },
  {
    "symbol": "QUN",
    "related_assets": null,
    "name": "QunQun"
  },
  {
    "symbol": "R",
    "related_assets": null,
    "name": "Revain"
  },
  {
    "symbol": "RBY",
    "related_assets": null,
    "name": "RubyCoin"
  },
  {
    "symbol": "RCN",
    "related_assets": null,
    "name": "Ripio"
  },
  {
    "symbol": "RCT",
    "related_assets": null,
    "name": "RealChain"
  },
  {
    "symbol": "RDD",
    "related_assets": null,
    "name": "ReddCoin"
  },
  {
    "symbol": "RDN",
    "related_assets": null,
    "name": "Raiden Network Token"
  },
  {
    "symbol": "REM",
    "related_assets": null,
    "name": "REMME"
  },
  {
    "symbol": "REN",
    "related_assets": null,
    "name": "Republic Protocol"
  },
  {
    "symbol": "REP",
    "related_assets": null,
    "name": "Augur"
  },
  {
    "symbol": "REQ",
    "related_assets": null,
    "name": "Request Network"
  },
  {
    "symbol": "RFR",
    "related_assets": null,
    "name": "Refereum"
  },
  {
    "symbol": "RHOC",
    "related_assets": null,
    "name": "RChain"
  },
  {
    "symbol": "RISE",
    "related_assets": null,
    "name": "Rise"
  },
  {
    "symbol": "RLC",
    "related_assets": null,
    "name": "iExec"
  },
  {
    "symbol": "RNT",
    "related_assets": null,
    "name": "OneRoot Network"
  },
  {
    "symbol": "RNTB",
    "related_assets": null,
    "name": "BitRent"
  },
  {
    "symbol": "RUFF",
    "related_assets": null,
    "name": "Ruff"
  },
  {
    "symbol": "RVN",
    "related_assets": null,
    "name": "Ravencoin"
  },
  {
    "symbol": "RVR",
    "related_assets": null,
    "name": "RevolutionVR"
  },
  {
    "symbol": "SAFEX",
    "related_assets": null,
    "name": "Safex"
  },
  {
    "symbol": "SALT",
    "related_assets": null,
    "name": "SALT"
  },
  {
    "symbol": "SAN",
    "related_assets": null,
    "name": "Santiment Network Token"
  },
  {
    "symbol": "SC",
    "related_assets": null,
    "name": "Siacoin"
  },
  {
    "symbol": "SEELE",
    "related_assets": null,
    "name": "Seele"
  },
  {
    "symbol": "SENC",
    "related_assets": null,
    "name": "Sentinel Chain"
  },
  {
    "symbol": "SENT",
    "related_assets": null,
    "name": "Sentinel"
  },
  {
    "symbol": "SHIP",
    "related_assets": null,
    "name": "ShipChain"
  },
  {
    "symbol": "SIB",
    "related_assets": null,
    "name": "SibCoin"
  },
  {
    "symbol": "SKB",
    "related_assets": null,
    "name": "Sakura Bloom"
  },
  {
    "symbol": "SKY",
    "related_assets": null,
    "name": "Skycoin"
  },
  {
    "symbol": "SLR",
    "related_assets": null,
    "name": "Solar Coin"
  },
  {
    "symbol": "SLS",
    "related_assets": null,
    "name": "SaluS"
  },
  {
    "symbol": "SMART",
    "related_assets": null,
    "name": "SmartCash"
  },
  {
    "symbol": "SNC",
    "related_assets": null,
    "name": "SunContract"
  },
  {
    "symbol": "SNGLS",
    "related_assets": null,
    "name": "SingularDTV"
  },
  {
    "symbol": "SNM",
    "related_assets": null,
    "name": "SONM"
  },
  {
    "symbol": "SNT",
    "related_assets": null,
    "name": "Status Network Token"
  },
  {
    "symbol": "SNTR",
    "related_assets": null,
    "name": "Silent Notary"
  },
  {
    "symbol": "SOAR",
    "related_assets": null,
    "name": "Soarcoin"
  },
  {
    "symbol": "SOC",
    "related_assets": null,
    "name": "All Sports"
  },
  {
    "symbol": "SOUL",
    "related_assets": null,
    "name": "Phantasma"
  },
  {
    "symbol": "SPANK",
    "related_assets": null,
    "name": "SpankChain"
  },
  {
    "symbol": "SPC",
    "related_assets": null,
    "name": "SpaceChain"
  },
  {
    "symbol": "SPD",
    "related_assets": null,
    "name": "Stipend"
  },
  {
    "symbol": "SPHTX",
    "related_assets": null,
    "name": "SophiaTX"
  },
  {
    "symbol": "SRN",
    "related_assets": null,
    "name": "SIRIN LABS Token"
  },
  {
    "symbol": "SS",
    "related_assets": null,
    "name": "Sharder"
  },
  {
    "symbol": "STEEM",
    "related_assets": null,
    "name": "Steem"
  },
  {
    "symbol": "STK",
    "related_assets": null,
    "name": "STK"
  },
  {
    "symbol": "STORJ",
    "related_assets": null,
    "name": "Storj"
  },
  {
    "symbol": "STORM",
    "related_assets": null,
    "name": "Storm"
  },
  {
    "symbol": "STQ",
    "related_assets": null,
    "name": "Storiqa Token"
  },
  {
    "symbol": "STRAT",
    "related_assets": null,
    "name": "Stratis"
  },
  {
    "symbol": "STX",
    "related_assets": null,
    "name": "Stox"
  },
  {
    "symbol": "SUB",
    "related_assets": null,
    "name": "Substratum"
  },
  {
    "symbol": "SWFTC",
    "related_assets": null,
    "name": "SwftCoin"
  },
  {
    "symbol": "SWM",
    "related_assets": null,
    "name": "Swarm"
  },
  {
    "symbol": "SWT",
    "related_assets": null,
    "name": "Swarm City Token"
  },
  {
    "symbol": "SXDT",
    "related_assets": null,
    "name": "Spectre.ai Dividend Token"
  },
  {
    "symbol": "SYS",
    "related_assets": null,
    "name": "Syscoin"
  },
  {
    "symbol": "TAAS",
    "related_assets": null,
    "name": "TaaS"
  },
  {
    "symbol": "TAU",
    "related_assets": null,
    "name": "Lamden Tau"
  },
  {
    "symbol": "TCT",
    "related_assets": null,
    "name": "TokenClub"
  },
  {
    "symbol": "TEL",
    "related_assets": null,
    "name": "Telcoin"
  },
  {
    "symbol": "TEN",
    "related_assets": null,
    "name": "Tokenomy"
  },
  {
    "symbol": "TFD",
    "related_assets": null,
    "name": "TE-FOOD"
  },
  {
    "symbol": "THC",
    "related_assets": null,
    "name": "The Hempcoin"
  },
  {
    "symbol": "THETA",
    "related_assets": null,
    "name": "Theta Token"
  },
  {
    "symbol": "TIME",
    "related_assets": null,
    "name": "Chrono Bank"
  },
  {
    "symbol": "TIX",
    "related_assets": null,
    "name": "Blocktix"
  },
  {
    "symbol": "TKN",
    "related_assets": null,
    "name": "TokenCard"
  },
  {
    "symbol": "TNB",
    "related_assets": null,
    "name": "Time New Bank"
  },
  {
    "symbol": "TNC",
    "related_assets": null,
    "name": "Trinity Network Credit"
  },
  {
    "symbol": "TNT",
    "related_assets": null,
    "name": "Tierion"
  },
  {
    "symbol": "TOA",
    "related_assets": null,
    "name": "Toa Coin"
  },
  {
    "symbol": "TOMO",
    "related_assets": null,
    "name": "TomoChain"
  },
  {
    "symbol": "TRAC",
    "related_assets": null,
    "name": "OriginTrail"
  },
  {
    "symbol": "TRST",
    "related_assets": null,
    "name": "TrustCoin"
  },
  {
    "symbol": "TRUE",
    "related_assets": null,
    "name": "True Chain"
  },
  {
    "symbol": "TRX",
    "related_assets": null,
    "name": "TRON"
  },
  {
    "symbol": "TTC",
    "related_assets": null,
    "name": "TTC Protocol"
  },
  {
    "symbol": "TUSD",
    "related_assets": null,
    "name": "True USD"
  },
  {
    "symbol": "UBC",
    "related_assets": null,
    "name": "Ubcoin"
  },
  {
    "symbol": "UBQ",
    "related_assets": null,
    "name": "Ubiq"
  },
  {
    "symbol": "UBT",
    "related_assets": null,
    "name": "Unibright"
  },
  {
    "symbol": "UKG",
    "related_assets": null,
    "name": "Unikoin Gold"
  },
  {
    "symbol": "UNO",
    "related_assets": null,
    "name": "Unobtanium"
  },
  {
    "symbol": "UP",
    "related_assets": null,
    "name": "UpToken"
  },
  {
    "symbol": "UPP",
    "related_assets": null,
    "name": "Sentinel Protocol"
  },
  {
    "symbol": "UQC",
    "related_assets": null,
    "name": "Uquid Coin"
  },
  {
    "symbol": "USDT",
    "related_assets": null,
    "name": "Tether"
  },
  {
    "symbol": "UTK",
    "related_assets": null,
    "name": "UTRUST"
  },
  {
    "symbol": "UTNP",
    "related_assets": null,
    "name": "Universa"
  },
  {
    "symbol": "UTT",
    "related_assets": null,
    "name": "United Traders Token"
  },
  {
    "symbol": "UUU",
    "related_assets": null,
    "name": "U Network"
  },
  {
    "symbol": "VEE",
    "related_assets": null,
    "name": "BLOCKv"
  },
  {
    "symbol": "VERI",
    "related_assets": null,
    "name": "Veritaseum"
  },
  {
    "symbol": "VIA",
    "related_assets": null,
    "name": "ViaCoin"
  },
  {
    "symbol": "VIB",
    "related_assets": null,
    "name": "Viberate"
  },
  {
    "symbol": "VIBE",
    "related_assets": null,
    "name": "VIBE"
  },
  {
    "symbol": "VITE",
    "related_assets": null,
    "name": "VITE"
  },
  {
    "symbol": "VRC",
    "related_assets": null,
    "name": "Vericoin"
  },
  {
    "symbol": "VTC",
    "related_assets": null,
    "name": "Vertcoin"
  },
  {
    "symbol": "VULC",
    "related_assets": null,
    "name": "Vulcano"
  },
  {
    "symbol": "WABI",
    "related_assets": null,
    "name": "WaBi"
  },
  {
    "symbol": "WAN",
    "related_assets": null,
    "name": "Wanchain"
  },
  {
    "symbol": "WAVES",
    "related_assets": null,
    "name": "Waves"
  },
  {
    "symbol": "WAX",
    "related_assets": null,
    "name": "WAX"
  },
  {
    "symbol": "WGR",
    "related_assets": null,
    "name": "Wagerr"
  },
  {
    "symbol": "WINGS",
    "related_assets": null,
    "name": "Wings DAO"
  },
  {
    "symbol": "WPR",
    "related_assets": null,
    "name": "WePower"
  },
  {
    "symbol": "WTC",
    "related_assets": null,
    "name": "Waltonchain"
  },
  {
    "symbol": "XAS",
    "related_assets": null,
    "name": "Asch"
  },
  {
    "symbol": "XAUR",
    "related_assets": null,
    "name": "Xaurum"
  },
  {
    "symbol": "XBY",
    "related_assets": null,
    "name": "XtraBYtes"
  },
  {
    "symbol": "XCP",
    "related_assets": null,
    "name": "CounterParty"
  },
  {
    "symbol": "XDCE",
    "related_assets": null,
    "name": "XinFin Network"
  },
  {
    "symbol": "XDN",
    "related_assets": null,
    "name": "DigitalNote "
  },
  {
    "symbol": "XEM",
    "related_assets": null,
    "name": "NemProject"
  },
  {
    "symbol": "XIN",
    "related_assets": null,
    "name": "Mixin"
  },
  {
    "symbol": "XLM",
    "related_assets": null,
    "name": "Stellar Lumens"
  },
  {
    "symbol": "XMR",
    "related_assets": null,
    "name": "Monero"
  },
  {
    "symbol": "XP",
    "related_assets": null,
    "name": "Experience Points"
  },
  {
    "symbol": "XPM",
    "related_assets": null,
    "name": "Primecoin"
  },
  {
    "symbol": "XRP",
    "related_assets": null,
    "name": "Ripple"
  },
  {
    "symbol": "XSN",
    "related_assets": null,
    "name": "Stakenet"
  },
  {
    "symbol": "XTZ",
    "related_assets": null,
    "name": "Tezos"
  },
  {
    "symbol": "XVG",
    "related_assets": null,
    "name": "Verge"
  },
  {
    "symbol": "XYO",
    "related_assets": null,
    "name": "XYO Network"
  },
  {
    "symbol": "XZC",
    "related_assets": null,
    "name": "ZCoin"
  },
  {
    "symbol": "YEE",
    "related_assets": null,
    "name": "YEE"
  },
  {
    "symbol": "YOYOW",
    "related_assets": null,
    "name": "YOYOW"
  },
  {
    "symbol": "ZAP",
    "related_assets": null,
    "name": "Zap"
  },
  {
    "symbol": "ZCL",
    "related_assets": null,
    "name": "ZClassic"
  },
  {
    "symbol": "ZCN",
    "related_assets": null,
    "name": "0chain"
  },
  {
    "symbol": "ZCO",
    "related_assets": null,
    "name": "Zebi"
  },
  {
    "symbol": "ZEC",
    "related_assets": null,
    "name": "ZCash"
  },
  {
    "symbol": "ZEN",
    "related_assets": null,
    "name": "ZenCash"
  },
  {
    "symbol": "ZIL",
    "related_assets": null,
    "name": "Zilliqa"
  },
  {
    "symbol": "ZIP",
    "related_assets": null,
    "name": "Zipper"
  },
  {
    "symbol": "ZPT",
    "related_assets": null,
    "name": "Zeepin"
  },
  {
    "symbol": "ZRX",
    "related_assets": null,
    "name": "0x"
  },
  {
    "symbol": "ZSC",
    "related_assets": null,
    "name": "Zeusshield"
  }
];

var list_coins2 = [
  {
  "symbol": "LTC"
},
{
  "symbol": "ETH"
},
{
  "symbol": "BTC"
}
];

function makeChart(analysis_type, list_coins, list_coins2) {
  var list_coins = list_coins;
  var list_coins2 = list_coins2;
  console.log(list_coins2);
  var name = document.getElementById("chart_name").value;
  var analysis_type = analysis_type;
  if(analysis_type.match(/^[0-9a-zA-Z]{1,32}$/)){
}
else{
  var analysis_type = 'fcas';
}
if(name.match(/^[0-9a-zA-Z]{1,32}$/)){
}
else{
  var name = 'ANT';
}
function yyyymmdd() {
  var x = new Date();
  var y = x.getFullYear().toString();
  var m = (x.getMonth() + 1).toString();
  var d = x.getDate().toString();
  (d.length == 1) && (d = '0' + d);
  (m.length == 1) && (m = '0' + m);
  var yyyymmdd = y + m + d;
  return y + '-' + m + '-' + d;
}

// var name = 'ANT',
// analysis_type = 'fcas';
let display_name = name + ' - Analysis type: ' + analysis_type;
var today = yyyymmdd();
////////////////////////////////////////////////////////////////////////////////////////// today usage below
var path = 'json/' + '2019-04-02' + '-history-' + name + '-' + analysis_type + '.json';
//
// function getCoinDataParsed(name, analysis_type){
//   // var display_name = name + ' - Analysis type: ' + analysis_type;
//   var today = yyyymmdd();
//   var name = name;
//   var analysis_type = analysis_type;
//   ////////////////////////////////////////////////////////////////////////////////////////// today usage below
//   var path = 'json/' + '2019-04-02' + '-history-' + name + '-' + analysis_type + '.json';
//   console.log(path);
//   $.getJSON(path, function(result){
//       // var result = JSON.stringify(JSON.parse(result),null,2);
//       console.log(result);
//       rawData = result;
//       var newData = new Array();
//       var return_array = new Array();
//       for (var i = 0; i < rawData.length; i++) {
//           var row = rawData[i];
//           // console.log(row.metric_date);
//           var date = new Date(row.metric_date);
//           // console.log(date);
//           var data = [date.getTime(), parseFloat(row.value)];
//           newData.push(data);
//       }
//       var tuples = new Array();
//       for (var key in newData) {
//           tuples.push([key, newData[key]]);
//       }
//
//       tuples.sort(function(a, b) {
//           a = a[1];
//           b = b[1];
//           return a < b ? -1 : (a > b ? 1 : 0);
//       });
//
//       var orderedData = [];
//       for (var i = 0; i < tuples.length; i++) {
//           var key = tuples[i][0];
//           var value = tuples[i][1];
//           orderedData.push(value);
//       }
//       return_array.push(name);
//       return_array.push(orderedData);
//       console.log(return_array);
//     });
//     return orderedData;
// }
window.return_array = new Array();

$.getJSON(path, function(result){
    // var result = JSON.stringify(JSON.parse(result),null,2);
    // console.log(result);
    rawData = result;
    var newData = new Array();
    for (var i = 0; i < rawData.length; i++) {
        var row = rawData[i];
        // console.log(row.metric_date);
        var date = new Date(row.metric_date);
        // console.log(date);
        var data = [date.getTime(), parseFloat(row.value)];
        newData.push(data);
    }
    var tuples = new Array();
    for (var key in newData) {
        tuples.push([key, newData[key]]);
    }

    tuples.sort(function(a, b) {
        a = a[1];
        b = b[1];
        return a < b ? -1 : (a > b ? 1 : 0);
    });

    var orderedData = [];
    for (var i = 0; i < tuples.length; i++) {
        var key = tuples[i][0];
        var value = tuples[i][1];
        orderedData.push(value);
    }

    var dct = {
                    name: name,
                    data: orderedData,
                    tooltip: {
                      valueDecimals: 2
                    }
                  };
    window.return_array.push(dct);


    // var orderedData = JSON.stringify(orderedData);
$(function() {
      series_counter = 0;
      var size_listcoins2 = Object.keys(list_coins2).length;
      console.log('length lc2');
      console.log(size_listcoins2);
      series = [];
      for (const [ key, value ] of Object.entries(list_coins2)) {
        console.log(key);
        let the_key = key + 1;
        series_counter += 1;
        console.log(value['symbol']);
        let name_symbol = value['symbol'];
        var path = 'json/' + '2019-04-02' + '-history-' + name_symbol + '-' + analysis_type + '.json';
        console.log(path);
        $.getJSON(path, function(result){

            // var result = JSON.stringify(JSON.parse(result),null,2);
            console.log(result);
            rawData = result;
            var newData = new Array();
            for (var i = 0; i < rawData.length; i++) {
                var row = rawData[i];
                // console.log(row.metric_date);
                var date = new Date(row.metric_date);
                // console.log(date);
                var data = [date.getTime(), parseFloat(row.value)];
                newData.push(data);
            }
            var tuples = new Array();
            for (var key in newData) {
                tuples.push([key, newData[key]]);
            }

            tuples.sort(function(a, b) {
                a = a[1];
                b = b[1];
                return a < b ? -1 : (a > b ? 1 : 0);
            });

            var orderedData = [];
            for (var i = 0; i < tuples.length; i++) {
                var key = tuples[i][0];
                var value = tuples[i][1];
                orderedData.push(value);
            }
            console.log(name_symbol);
            var dct = {
                            name: name_symbol,
                            data: orderedData,
                            tooltip: {
                              valueDecimals: 2
                            }
                          };
            window.return_array.push(dct);
            // series.append(dict(dct));
            console.log(dct);
            console.log(window.return_array);
          // }
        });
}

    window.chart = new Highcharts.StockChart({
        chart: {
            renderTo: 'container-analysis'
        },

        rangeSelector: {
            selected: 4
        },

        title: {
            text: display_name
        },

        series: window.return_array

// });
});
});
// });
// }
});
////////////////////

// series: [{
//     name: name,
//     data: orderedData,
//     tooltip: {
//         valueDecimals: 2
//     }}]

// $.getJSON('json/' + today + '-history-' + name + '-' + analysis_type + '.json',  function (data) {
//

//
//   // As we're loading the data asynchronously, we don't know what order it will arrive. So
//   // we keep a counter and create the chart when all the data is loaded.
//   seriesCounter += 1;
//
//   if (seriesCounter === names.length) {
//     createChart();
//   }
// }); );
}
console.log(list_coins);
// makeChart('fcas', list_coins, list_coins2);
</script>


    <select id="chart_name" onchange="makeChart('fcas', list_coins, list_coins2)">
      <script>

     html = "";
     for (const [ key, value ] of Object.entries(list_coins)) {

         html += "<option value=" + value['symbol']  + ">" + value['symbol'] + "</option>"
     }
     document.getElementById("chart_name").innerHTML = html;

 </script>
    </select>
    <!-- <input type="button" value="Select coin" onchange="makeChart('fcas')" /> -->
</html>
