// convo variables
var convoFirstContainerId = 0;
var convoFirstId = 0;
var convoFirstSender = -1;
var convoLastContainerId = 0;
var convoLastId = 0;
var convoLastSender = -1;
var convoFirstDone = true;
var convoRetriever = null;

// creation variables
var newMessage = false;
var recentSearch = '';
var recipientId = 0;
var recipientName = '';
var recipientImage = '';

// inbox variables
var messageLastOffset = 3;
var messageTotalOffset = 3;
var messageLastReached = false;
var messageDeleteId = 0;
var existingMessages = '';